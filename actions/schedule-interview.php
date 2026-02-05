<?php
require_once '../config/db.php';
require_once '../classes/Interview.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->getConnection();
    $interview = new Interview($conn);

    $applicationId = $_POST['application_id'] ?? null;
    $candidateId = $_POST['candidate_id'] ?? null;
    $jobName = $_POST['job_name'] ?? null;
    $interviewDate = $_POST['interview_date'] ?? null;
    $interviewTime = $_POST['interview_time'] ?? null;
    $recruiter_id = $_POST['recruiter_id'] ?? null;

    $jobNameC = $_POST['jobC_name'] ?? null;
    $interviewDateC = $_POST['interviewC_date'] ?? null;
    $interviewTimeC = $_POST['interviewC_time'] ?? null;
    $interviewCount = $_POST['interview_count'] ??null;
    $idC = $_POST['id'] ?? null;

    $action = $_POST['action'];


    if ($action == 'save') {
        if ($interview->scheduleInterview($applicationId, $recruiter_id, $candidateId, $jobName, $interviewDate, $interviewTime)) {
            $_SESSION['message'] = 'Interview scheduled successfully.';
        } else {
            $_SESSION['message'] = 'An error occurred while scheduling the interview.';
        }
    } elseif ($action == 'update') {
        if ($interview->updateInterview($applicationId, $interviewDate, $interviewTime)) {
            $_SESSION['message'] = 'Interview updated successfully.';
        } else {
            $_SESSION['message'] = 'An error occurred while updating the interview.';
        }
    } elseif ($action == 'delete') {
        if ($interview->deleteInterview($applicationId)) {
            $_SESSION['message'] = 'Interview deleted successfully.';
        } else {
            $_SESSION['message'] = 'An error occurred while deleting the interview.';
        }
    } elseif ($action == 'save_to_calendar') {
        // Get interview counts by date, time, and job name
        

            $interview->saveToCalendar($recruiter_id, $jobNameC, $interviewDateC, $interviewTimeC, $interviewCount);
    } elseif ($action == 'Update_to_calendar'){

        $interview->updateCalendarRecord($idC, $recruiter_id, $jobNameC, $interviewDateC, $interviewTimeC, $interviewCount);

    }
    

    header('Location: http://localhost/e-recruitment-system6/dashboard/RTboard/schedule-interview.php');
    exit();
}
