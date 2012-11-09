<?php

/**
 * @file ReviewFormHandler.inc.php
 *
 * Copyright (c) 2000-2012 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class ReviewFormHandler
 * @ingroup pages_manager
 *
 * @brief Handle requests for review form management functions.
 *
*/

import('pages.manager.ManagerHandler');

class ReviewFormHandler extends ManagerHandler {
	/**
	 * Constructor
	 */
	function ReviewFormHandler() {
		parent::ManagerHandler();
	}

	/**
	 * Display a list of review forms within the current conference.
	 */
	function reviewForms($args, &$request) {
		$this->validate();
		$this->setupTemplate($request);

		$conference =& $request->getConference();
		$rangeInfo =& Handler::getRangeInfo($request, 'reviewForms');
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForms =& $reviewFormDao->getByAssocId(ASSOC_TYPE_CONFERENCE, $conference->getId(), $rangeInfo);
		$reviewAssignmentDao =& DAORegistry::getDAO('ReviewAssignmentDAO');

		$templateMgr =& TemplateManager::getManager($request);
		$templateMgr->addJavaScript('lib/pkp/js/lib/jquery/plugins/jquery.tablednd.js');
		$templateMgr->addJavaScript('lib/pkp/js/functions/tablednd.js');
		$templateMgr->assign_by_ref('reviewForms', $reviewForms);
		$templateMgr->assign('completeCounts', $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), true));
		$templateMgr->assign('incompleteCounts', $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), false));
		$templateMgr->assign('helpTopicId','conference.managementPages.reviewForms');
		$templateMgr->display('manager/reviewForms/reviewForms.tpl');
	}

	/**
	 * Display form to create a new review form.
	 */
	function createReviewForm($args, &$request) {
		$this->editReviewForm($args, $request);
	}

	/**
	 * Display form to create/edit a review form.
	 * @param $args array
	 * @param $request PKPRequest
	 */
	function editReviewForm($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());
		$completeCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), true);
		$incompleteCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), false);

		if ($reviewFormId != null && (!isset($reviewForm) || $completeCounts[$reviewFormId] != 0 || $incompleteCounts[$reviewFormId] != 0)) {
			$request->redirect(null, null, null, 'reviewForms');
		} else {
			$this->setupTemplate($request, true, $reviewForm);
			$templateMgr =& TemplateManager::getManager($request);

			if ($reviewFormId == null) {
				$templateMgr->assign('pageTitle', 'manager.reviewForms.create');
			} else {
				$templateMgr->assign('pageTitle', 'manager.reviewForms.edit');
			}

			import('classes.manager.form.ReviewFormForm');
			$reviewFormForm = new ReviewFormForm($reviewFormId);

			if ($reviewFormForm->isLocaleResubmit()) {
				$reviewFormForm->readInputData();
			} else {
				$reviewFormForm->initData();
			}
			$reviewFormForm->display();
		}
	}

	/**
	 * Save changes to a review form.
	 */
	function updateReviewForm($args, &$request) {
		$this->validate();
		$this->setupTemplate($request, true, $reviewForm);

		$reviewFormId = $request->getUserVar('reviewFormId') === null? null : (int) $request->getUserVar('reviewFormId');

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());

		$completeCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), true);
		$incompleteCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), false);
		if ($reviewFormId != null && (!isset($reviewForm) || $completeCounts[$reviewFormId] != 0 || $incompleteCounts[$reviewFormId] != 0)) {
			$request->redirect(null, null, null, 'reviewForms');
		}

		import('classes.manager.form.ReviewFormForm');
		$reviewFormForm = new ReviewFormForm($reviewFormId);
		$reviewFormForm->readInputData();

		if ($reviewFormForm->validate()) {
			$reviewFormForm->execute();
			$request->redirect(null, null, null, 'reviewForms');
		} else {
			$templateMgr =& TemplateManager::getManager($request);

			if ($reviewFormId == null) {
				$templateMgr->assign('pageTitle', 'manager.reviewForms.create');
			} else {
				$templateMgr->assign('pageTitle', 'manager.reviewForms.edit');
			}

			$reviewFormForm->display();
		}
	}

	/**
	 * Preview a review form.
	 * @param $args array first parameter is the ID of the review form to preview
	 */
	function previewReviewForm($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());
		$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');
		$reviewFormElements =& $reviewFormElementDao->getReviewFormElements($reviewFormId);

		if (!isset($reviewForm)) {
			$request->redirect(null, null, null, 'reviewForms');
		}

		$completeCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_JOURNAL, $journal->getId(), true);
		$incompleteCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_JOURNAL, $journal->getId(), false);
		if ($completeCounts[$reviewFormId] != 0 || $incompleteCounts[$reviewFormId] != 0) {
			$this->setupTemplate($request, true);
		} else {
			$this->setupTemplate($request, true, $reviewForm);
		}

		$templateMgr =& TemplateManager::getManager($request);

		$templateMgr->assign('pageTitle', 'manager.reviewForms.preview');
		$templateMgr->assign_by_ref('reviewForm', $reviewForm);
		$templateMgr->assign('reviewFormElements', $reviewFormElements);
		$templateMgr->assign('completeCounts', $completeCounts);
		$templateMgr->assign('incompleteCounts', $incompleteCounts);
		$templateMgr->register_function('form_language_chooser', array('ReviewFormHandler', 'smartyFormLanguageChooser'));
		$templateMgr->assign('helpTopicId','conference.managementPages.reviewForms');
		$templateMgr->display('manager/reviewForms/previewReviewForm.tpl');
	}

	/**
	 * Delete a review form.
	 * @param $args array first parameter is the ID of the review form to delete
	 */
	function deleteReviewForm($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());

		$completeCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_JOURNAL, $journal->getId(), true);
		$incompleteCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_JOURNAL, $journal->getId(), false);
		if (isset($reviewForm) && $completeCounts[$reviewFormId] == 0 && $incompleteCounts[$reviewFormId] == 0) {
			$reviewAssignmentDao =& DAORegistry::getDAO('ReviewAssignmentDAO');
			$reviewAssignments =& $reviewAssignmentDao->getByReviewFormId($reviewFormId);

			foreach ($reviewAssignments as $reviewAssignment) {
				$reviewAssignment->setReviewFormId('');
				$reviewAssignmentDao->updateReviewAssignment($reviewAssignment);
			}

			$reviewFormDao->deleteById($reviewFormId);
		}

		$request->redirect(null, null, null, 'reviewForms');
	}

	/**
	 * Activate a published review form.
	 * @param $args array first parameter is the ID of the review form to activate
	 */
	function activateReviewForm($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());

		if (isset($reviewForm) && !$reviewForm->getActive()) {
			$reviewForm->setActive(1);
			$reviewFormDao->updateObject($reviewForm);
		}

		$request->redirect(null, null, null, 'reviewForms');
	}

	/**
	 * Deactivate a published review form.
	 * @param $args array first parameter is the ID of the review form to deactivate
	 */
	function deactivateReviewForm($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());

		if (isset($reviewForm) && $reviewForm->getActive()) {
			$reviewForm->setActive(0);
			$reviewFormDao->updateObject($reviewForm);
		}

		$request->redirect(null, null, null, 'reviewForms');
	}

	/**
	 * Copy a published review form.
	 */
	function copyReviewForm($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());

		if (isset($reviewForm)) {
			$reviewForm->setActive(0);
			$reviewForm->setSequence(REALLY_BIG_NUMBER);
			$newReviewFormId = $reviewFormDao->insertObject($reviewForm);
			$reviewFormDao->resequenceReviewForms(ASSOC_TYPE_CONFERENCE, $conference->getId());

			$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');
			$reviewFormElements =& $reviewFormElementDao->getReviewFormElements($reviewFormId);
			foreach ($reviewFormElements as $reviewFormElement) {
				$reviewFormElement->setReviewFormId($newReviewFormId);
				$reviewFormElement->setSequence(REALLY_BIG_NUMBER);
				$reviewFormElementDao->insertObject($reviewFormElement);
				$reviewFormElementDao->resequenceReviewFormElements($newReviewFormId);
			}

		}

		$request->redirect(null, null, null, 'reviewForms');
	}

	/**
	 * Change the sequence of a review form.
	 */
	function moveReviewForm($args, &$request) {
		$this->validate();

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($request->getUserVar('reviewFormId'), ASSOC_TYPE_CONFERENCE, $conference->getId());

		if (isset($reviewForm)) {
			$reviewForm->setSequence($reviewForm->getSequence() + ($request->getUserVar('d') == 'u' ? -1.5 : 1.5));
			$reviewFormDao->updateObject($reviewForm);
			$reviewFormDao->resequenceReviewForms(ASSOC_TYPE_CONFERENCE, $conference->getId());
		}

		$request->redirect(null, null, null, 'reviewForms');
	}

	/**
	 * Display a list of the review form elements within a review form.
	 */
	function reviewFormElements($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? $args[0] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());
		$completeCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), true);
		$incompleteCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), false);

		if (!isset($reviewForm) || $completeCounts[$reviewFormId] != 0 || $incompleteCounts[$reviewFormId] != 0) {
			$request->redirect(null, null, null, 'reviewForms');
		}

		$rangeInfo =& Handler::getRangeInfo($request, 'reviewFormElements');
		$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');
		$reviewFormElements =& $reviewFormElementDao->getReviewFormElementsByReviewForm($reviewFormId, $rangeInfo);

		$unusedReviewFormTitles =& $reviewFormDao->getTitlesByAssocId(ASSOC_TYPE_CONFERENCE, $conference->getId(), 0);

		$this->setupTemplate($request, true, $reviewForm);
		$templateMgr =& TemplateManager::getManager($request);

		$templateMgr->addJavaScript('lib/pkp/js/lib/jquery/plugins/jquery.tablednd.js');
		$templateMgr->addJavaScript('lib/pkp/js/functions/tablednd.js');

		$templateMgr->assign_by_ref('unusedReviewFormTitles', $unusedReviewFormTitles);
		$templateMgr->assign_by_ref('reviewFormElements', $reviewFormElements);
		$templateMgr->assign('reviewFormId', $reviewFormId);
		import('lib.pkp.classes.reviewForm.ReviewFormElement');
		$templateMgr->assign_by_ref('reviewFormElementTypeOptions', ReviewFormElement::getReviewFormElementTypeOptions());
		$templateMgr->assign('helpTopicId','conference.managementPages.reviewForms');
		$templateMgr->display('manager/reviewForms/reviewFormElements.tpl');
	}

	/**
	 * Display form to create a new review form element.
	 */
	function createReviewFormElement($args, &$request) {
		$this->editReviewFormElement($args);
	}

	/**
	 * Display form to create/edit a review form element.
	 * @param $args ($reviewFormId, $reviewFormElementId)
	 */
	function editReviewFormElement($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;
		$reviewFormElementId = isset($args[1]) ? (int) $args[1] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());
		$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');
		$completeCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), true);
		$incompleteCounts = $reviewFormDao->getUseCounts(ASSOC_TYPE_CONFERENCE, $conference->getId(), false);

		if (!isset($reviewForm) || $completeCounts[$reviewFormId] != 0 || $incompleteCounts[$reviewFormId] != 0 || ($reviewFormElementId != null && !$reviewFormElementDao->reviewFormElementExists($reviewFormElementId, $reviewFormId))) {
			$request->redirect(null, null, null, 'reviewFormElements', array($reviewFormId));
		}

		$this->setupTemplate($request, true, $reviewForm);
		$templateMgr =& TemplateManager::getManager($request);

		if ($reviewFormElementId == null) {
			$templateMgr->assign('pageTitle', 'manager.reviewFormElements.create');
		} else {
			$templateMgr->assign('pageTitle', 'manager.reviewFormElements.edit');
		}

		import('classes.manager.form.ReviewFormElementForm');
		$reviewFormElementForm = new ReviewFormElementForm($reviewFormId, $reviewFormElementId);
		if ($reviewFormElementForm->isLocaleResubmit()) {
			$reviewFormElementForm->readInputData();
		} else {
			$reviewFormElementForm->initData();
		}

		$reviewFormElementForm->display();
	}

	/**
	 * Save changes to a review form element.
	 */
	function updateReviewFormElement($args, &$request) {
		$this->validate();

		$reviewFormId = $request->getUserVar('reviewFormId') === null? null : (int) $request->getUserVar('reviewFormId');
		$reviewFormElementId = $request->getUserVar('reviewFormElementId') === null? null : (int) $request->getUserVar('reviewFormElementId');

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');

		$reviewForm =& $reviewFormDao->getReviewForm($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId());
		$this->setupTemplate($request, true, $reviewForm);

		if (!$reviewFormDao->unusedReviewFormExists($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId()) || ($reviewFormElementId != null && !$reviewFormElementDao->reviewFormElementExists($reviewFormElementId, $reviewFormId))) {
			$request->redirect(null, null, null, 'reviewFormElements', array($reviewFormId));
		}

		import('classes.manager.form.ReviewFormElementForm');
		$reviewFormElementForm = new ReviewFormElementForm($reviewFormId, $reviewFormElementId);
		$reviewFormElementForm->readInputData();
		$formLocale = $reviewFormElementForm->getFormLocale();

		// Reorder response items
		$response = $reviewFormElementForm->getData('possibleResponses');
		if (isset($response[$formLocale]) && is_array($response[$formLocale])) {
			usort($response[$formLocale], create_function('$a,$b','return $a[\'order\'] == $b[\'order\'] ? 0 : ($a[\'order\'] < $b[\'order\'] ? -1 : 1);'));
		}
		$reviewFormElementForm->setData('possibleResponses', $response);

		if ($request->getUserVar('addResponse')) {
			// Add a response item
			$editData = true;
			$response = $reviewFormElementForm->getData('possibleResponses');
			if (!isset($response[$formLocale]) || !is_array($response[$formLocale])) {
				$response[$formLocale] = array();
				$lastOrder = 0;
			} else {
				$lastOrder = $response[$formLocale][count($response[$formLocale])-1]['order'];
			}
			array_push($response[$formLocale], array('order' => $lastOrder+1));
			$reviewFormElementForm->setData('possibleResponses', $response);

		} else if (($delResponse = $request->getUserVar('delResponse')) && count($delResponse) == 1) {
			// Delete a response item
			$editData = true;
			list($delResponse) = array_keys($delResponse);
			$delResponse = (int) $delResponse;
			$response = $reviewFormElementForm->getData('possibleResponses');
			if (!isset($response[$formLocale])) $response[$formLocale] = array();
			array_splice($response[$formLocale], $delResponse, 1);
			$reviewFormElementForm->setData('possibleResponses', $response);
		}

		if (!isset($editData) && $reviewFormElementForm->validate()) {
			$reviewFormElementForm->execute();
			$request->redirect(null, null, null, 'reviewFormElements', array($reviewFormId));
		} else {
			$conference =& $request->getConference();
			$templateMgr =& TemplateManager::getManager($request);
			if ($reviewFormElementId == null) {
				$templateMgr->assign('pageTitle', 'manager.reviewFormElements.create');
			} else {
				$templateMgr->assign('pageTitle', 'manager.reviewFormElements.edit');
			}

			$reviewFormElementForm->display();
		}
	}

	/**
	 * Delete a review form element.
	 * @param $args array ($reviewFormId, $reviewFormElementId)
	 */
	function deleteReviewFormElement($args, &$request) {
		$this->validate();

		$reviewFormId = isset($args[0]) ? (int)$args[0] : null;
		$reviewFormElementId = isset($args[1]) ? (int) $args[1] : null;

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');

		if ($reviewFormDao->unusedReviewFormExists($reviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId())) {
			$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');
			$reviewFormElementDao->deleteById($reviewFormElementId);
		}
		$request->redirect(null, null, null, 'reviewFormElements', array($reviewFormId));
	}

	/**
	 * Change the sequence of a review form element.
	 */
	function moveReviewFormElement($args, &$request) {
		$this->validate();

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');
		$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');
		$reviewFormElement =& $reviewFormElementDao->getReviewFormElement($request->getUserVar('reviewFormElementId'));

		if (isset($reviewFormElement) && $reviewFormDao->unusedReviewFormExists($reviewFormElement->getReviewFormId(), ASSOC_TYPE_CONFERENCE, $conference->getId())) {
			$reviewFormElement->setSequence($reviewFormElement->getSequence() + ($request->getUserVar('d') == 'u' ? -1.5 : 1.5));
			$reviewFormElementDao->updateObject($reviewFormElement);
			$reviewFormElementDao->resequenceReviewFormElements($reviewFormElement->getReviewFormId());
		}

		$request->redirect(null, null, null, 'reviewFormElements', array($reviewFormElement->getReviewFormId()));
	}

	/**
	 * Copy review form elemnts to another review form.
	 */
	function copyReviewFormElement($args, &$request) {
		$this->validate();

		$copy = $request->getUserVar('copy');
		$targetReviewFormId = $request->getUserVar('targetReviewForm');

		$conference =& $request->getConference();
		$reviewFormDao =& DAORegistry::getDAO('ReviewFormDAO');

		if (is_array($copy) && $reviewFormDao->unusedReviewFormExists($targetReviewFormId, ASSOC_TYPE_CONFERENCE, $conference->getId())) {
			$reviewFormElementDao =& DAORegistry::getDAO('ReviewFormElementDAO');
			foreach ($copy as $reviewFormElementId) {
				$reviewFormElement =& $reviewFormElementDao->getReviewFormElement($reviewFormElementId);
				if (isset($reviewFormElement) && $reviewFormDao->unusedReviewFormExists($reviewFormElement->getReviewFormId(), ASSOC_TYPE_CONFERENCE, $conference->getId())) {
					$reviewFormElement->setReviewFormId($targetReviewFormId);
					$reviewFormElement->setSequence(REALLY_BIG_NUMBER);
					$reviewFormElementDao->insertObject($reviewFormElement);
					$reviewFormElementDao->resequenceReviewFormElements($targetReviewFormId);
				}
				unset($reviewFormElement);
			}
		}

		$request->redirect(null, null, null, 'reviewFormElements', array($targetReviewFormId));
	}

	function setupTemplate($request, $subclass = false, $reviewForm = null) {
		parent::setupTemplate($request, true);
		if ($subclass) {
			$templateMgr =& TemplateManager::getManager($request);
			$templateMgr->append('pageHierarchy', array($request->url(null, null, 'manager', 'reviewForms'), 'manager.reviewForms'));
		}
		if ($reviewForm) {
			$templateMgr->append('pageHierarchy', array($request->url(null, null, 'manager', 'editReviewForm', $reviewForm->getId()), $reviewForm->getLocalizedTitle(), true));
		}
	}
}

?>
