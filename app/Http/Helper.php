<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202309-V1.3>
 * @link    <https://www.defenzelite.com>
 */


use Illuminate\Support\Facades\File;

if (!function_exists('optionCanChecker')) {
    function optionCanChecker($permission)
    {
        $role = \Auth::user()->roles[0];
        if ($permission != null || $permission != '') {
            if ($role->hasPermissionTo($permission)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
}

if (!function_exists('getUserRoleById')) {
    function getUserRoleById($id)
    {
        return App\User::find($id)->getRoleNames()[0]??"";
    }
}
if (!function_exists('getReviewerData')) {
    function getReviewerData()
    {
        return \App\User::role('Reviewer')->get();
    }
}
if (!function_exists('getTypistData')) {
    function getTypistData()
    {
        return \App\User::role('Typist')->get();
    }
}
if (!function_exists('getTeacherUerData')) {
    function getTeacherUerData()
    {
        return \App\User::role('Teacher')->get();
    }
}
if (!function_exists('getAssistantUerData')) {
    function getAssistantUerData()
    {
        return \App\User::role('Assistant')->get();
    }
}
if (!function_exists('getStudentData')) {
    function getStudentData()
    {
        return \App\User::role('Student')->get();
    }
}
if (!function_exists('getFormattedDate')) {
    function getFormattedDate($date)
    {
        $data = getDateFormat();
        $format = $data[getSetting('date_format')]['value'];
        $format_type = $data[getSetting('date_format')]['format_type'];
        // return \Carbon\Carbon::parse($date)->$format_type($format);
        return toLocalTime(\Carbon\Carbon::parse($date), $format);
    }
}
if (!function_exists('getPrefixZeros')) {
    function getPrefixZeros($id)
    {
        $var = '_'.(1000000 +$id);
        return str_replace('_1', '', $var);
    }
}

if (!function_exists('getAssistantUserData')) {
    function getAssistantUserData()
    {
        return \App\User::role('Assistant')->get();
    }
}
if (!function_exists('getOrderData')) {
    function getOrderData()
    {
        return \App\Models\Order::get();
    }
}
if (!function_exists('getStudentUerData')) {
    function getStudentUerData()
    {
        return \App\User::role('Student')->get();
    }
}
if (!function_exists('isTeacher')) {
    function isTeacher($id)
    {
        if (getUserRoleById($id)== "Teacher") {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('isAssistant')) {
    function isAssistant($id)
    {
        if (getUserRoleById($id)== "Assistant") {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('isTypist')) {
    function isTypist($id)
    {
        if (getUserRoleById($id)== "Typist") {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('isReviewer')) {
    function isReviewer($id)
    {
        if (getUserRoleById($id)== "Reviewer") {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('isAdmin')) {
    function isAdmin($id)
    {
        if (getUserRoleById($id)== "Admin") {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('isManager')) {
    function isManager($id)
    {
        if (getUserRoleById($id)== "Manager") {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('isStudent')) {
    function isStudent($id)
    {
        if (getUserRoleById($id)== "Student") {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('getSubjectNameById')) {
    function getSubjectNameById($id)
    {
        return getCourseSubjectNameById(\App\Models\Subject::whereId($id)->first()->course_subject_id ?? "Deleted");
    }
}
if (!function_exists('getQuestionBundleDataByTestPaperBundleId')) {
    function getQuestionBundleDataByTestPaperBundleId($id)
    {
        return \App\Models\TestPaperQuestionBundle::whereId($id)->first();
    }
}
if (!function_exists('getCourseSubjectIdBySubjectId')) {
    function getCourseSubjectIdBySubjectId($id)
    {
        return \App\Models\Subject::whereId($id)->first()->course_subject_id ?? 0;
    }
}
if (!function_exists('getCourseDataBySubjectId')) {
    function getCourseDataBySubjectId($id)
    {
        return \App\Models\Subject::where('id', $id)->value('course_subject_id');
        // $subject = \App\Models\CourseSubject::where('id', $sub_id)->first();
        // return \App\Models\Subject::whereId($subject->id)->first()->id ?? 0;
    }
}
if (!function_exists('getSubjectDateBySubjectId')) {
    function getSubjectDateBySubjectId($id)
    {
        return \App\Models\Subject::whereId($id)->first();
    }
}
if (!function_exists('getTestPaperBundleNameById')) {
    function getTestPaperBundleNameById($id)
    {
        return \App\Models\TestPaperBundle::whereId($id)->first()->name ?? '--';
    }
}
if (!function_exists('getCourseSubjectNameById')) {
    function getCourseSubjectNameById($id)
    {
        return \App\Models\CourseSubject::whereId($id)->first()->name ?? "Deleted";
    }
}

if (!function_exists('getSubjectData')) {
    function getSubjectData()
    {
        return \App\Models\Subject::get();
    }
}
if (!function_exists('getSubjectChapters')) {
    function getSubjectChapters()
    {
        return \App\Models\SubjectChapter::get();
    }
}
if (!function_exists('getSubjectChapterData')) {
    function getSubjectChapterData($s_id)
    {
        return \App\Models\SubjectChapter::whereSubjectId($s_id)->orderBy('sequence', 'asc')->get() ?? "N/A";
    }
}
if (!function_exists('getSubjectChapterDataBySubjectId')) {
    function getSubjectChapterDataBySubjectId($id)
    {
        return \App\Models\SubjectChapter::whereSubjectId($id)->orderBy('sequence', 'asc')->get();
    }
}
if (!function_exists('getChapterTopicDataByChapterId')) {
    function getChapterTopicDataByChapterId($id)
    {
        return \App\Models\ChapterTopic::whereChapterId($id)->get();
    }
}

if (!function_exists('getChapterTopicData')) {
    function getChapterTopicData()
    {
        return \App\Models\ChapterTopic::get();
    }
}
if (!function_exists('getSubjectChapterNameId')) {
    function getSubjectChapterNameId($id)
    {
        return \App\Models\SubjectChapter::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getSubjectChapterSequenceNumber')) {
    function getSubjectChapterSequenceNumber($id)
    {
        return \App\Models\SubjectChapter::whereId($id)->first()->sequence ?? " ";
    }
}
if (!function_exists('getChapterTopicNameId')) {
    function getChapterTopicNameId($id)
    {
        return \App\Models\ChapterTopic::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getSubjectDataByTestId')) {
    function getSubjectDataByTestId($id)
    {
        return \App\Models\Subject::whereTestPaperId($id)->get();
    }
}

if (!function_exists('getQuestionDataBySubjectId')) {
    function getQuestionDataBySubjectId($id)
    {
        return \App\Models\Question::whereSubjectId($id)->get();
    }
}
if (!function_exists('getQuestionBookDataBySubjectId')) {
    function getQuestionBookDataBySubjectId($id)
    {
        return \App\Models\QuestionBook::whereSubjectId($id)->get();
    }
}
if (!function_exists('getTestPaperBundleCountBySubjectId')) {
    function getTestPaperBundleCountBySubjectId($id)
    {
        return \App\Models\TestPaperBundle::whereSubjectId($id)->get();
    }
}

if (!function_exists('getQuestionDataByTopicId')) {
    function getQuestionDataByTopicId($id)
    {
        return \App\Models\Question::whereChapterTopicId($id)->get();
    }
}

if (!function_exists('getPublishedQuestionDataByTopicId')) {
    function getPublishedQuestionDataByTopicId($id)
    {
        return \App\Models\Question::whereChapterTopicId($id)->whereIsPublished(1)->get();
    }
}
if (!function_exists('getPublishedQuestionDataByChapterId')) {
    function getPublishedQuestionDataByChapterId($id)
    {
        return \App\Models\Question::where('subject_chapter_id', $id)->whereIsPublished(1)->get();
    }
}

if (!function_exists('getShortQuestionCountByChapterId')) {
    function getShortQuestionCountByChapterId($s_id, $sub_id)
    {
        return \App\Models\Question::whereSubjectChapterId($s_id)->where('question_type', 1)->whereSubjectId($sub_id)->whereIsPublished(1)->count();
    }
}
if (!function_exists('getLongQuestionCountByChapterId')) {
    function getLongQuestionCountByChapterId($s_id, $sub_id)
    {
        return \App\Models\Question::whereSubjectChapterId($s_id)->where('question_type', 2)->whereSubjectId($sub_id)->whereIsPublished(1)->count();
    }
}
if (!function_exists('getShortQuestionCountBySubjectId')) {
    function getShortQuestionCountBySubjectId($s_id)
    {
        return \App\Models\Question::whereSubjectId($s_id)->where('is_published', 1)->where('question_type', 1)->count();
    }
}
if (!function_exists('getLongQuestionCountBySubjectId')) {
    function getLongQuestionCountBySubjectId($s_id)
    {
        return \App\Models\Question::whereSubjectId($s_id)->where('question_type', 2)->where('is_published', 1)->count();
    }
}

if (!function_exists('getQuestionCountByChapterAndTopicId')) {
    function getQuestionCountByChapterAndTopicId($s_id, $c_id, $sub_id)
    {
        return \App\Models\Question::whereSubjectChapterId($s_id)->whereChapterTopicId($c_id)->whereSubjectId($sub_id)->whereIsPublished(1)->count();
    }
}
if (!function_exists('getQuestionCountByChapterId')) {
    function getQuestionCountByChapterId($s_id, $sub_id)
    {
        return \App\Models\Question::whereSubjectChapterId($s_id)->whereSubjectId($sub_id)->whereIsPublished(1)->count();
    }
}

if (!function_exists('getSubjectVideoCountByChapterId')) {
    function getSubjectVideoCountByChapterId($s_id)
    {
        return \App\Models\SubjectVideo::whereChapterId($s_id)->whereIsPublished(1)->get()->count();
    }
}
if (!function_exists('getSubjectVideoCountBySubjectId')) {
    function getSubjectVideoCountBySubjectId($s_id)
    {
        return \App\Models\SubjectVideo::whereSubjectId($s_id)->whereIsPublished(1)->get()->count();
    }
}

if (!function_exists('getSubjectVideoCountByChapterAndTopicId')) {
    function getSubjectVideoCountByChapterAndTopicId($s_id, $c_id)
    {
        return \App\Models\SubjectVideo::whereChapterId($s_id)->whereTopicId($c_id)->whereIsPublished(1)->get()->count();
    }
}

if (!function_exists('getStudentQuestionProgressCountByUserAndTopicId')) {
    function getStudentQuestionProgressCountByUserAndTopicId($t_id)
    {
        return \App\Models\StudentQuestionProgress::whereUserId(\Auth::id())->whereTopicId($t_id)->get()->count() ?? 1;
    }
}

if (!function_exists('getStudentVideoProgressCountByUserAndTopicId')) {
    function getStudentVideoProgressCountByUserAndTopicId($t_id)
    {
        return \App\Models\StudentVideoProgress::whereUserId(\Auth::id())->whereTopicId($t_id)->get()->count() ?? 1;
    }
}

if (!function_exists('getQuestionDataById')) {
    function getQuestionDataById($id)
    {
        return \App\Models\Question::whereId($id)->first();
    }
}

if (!function_exists('getPublishedQuestionDataById')) {
    function getPublishedQuestionDataById($id)
    {
        return \App\Models\Question::whereId($id)->whereIsPublished(1)->first();
    }
}

if (!function_exists('getOnlyPublishedQuestionCount')) {
    function getOnlyPublishedQuestionCount()
    {
        return \App\Models\Question::whereIsPublished(1)->get()->count() ?? 0;
    }
}

if (!function_exists('getSubjectVideoDataById')) {
    function getSubjectVideoDataById($id)
    {
        if ($id != null) {
            return \App\Models\SubjectVideo::whereId($id)->whereIsPublished(1)->first();
        } else {
            return null;
        }
    }
}
if (!function_exists('getTrashQuestionDataById')) {
    function getTrashQuestionDataById($id)
    {
        return \App\Models\Question::onlyTrashed()->whereId($id)->first();
    }
}

if (!function_exists('getQuestionIdsDataByTopicId')) {
    function getQuestionIdsDataByTopicId($id)
    {
        return \App\Models\Question::whereChapterTopicId($id)->pluck('id');
    }
}

if (!function_exists('getPublishedQuestionIdsDataByTopicId')) {
    function getPublishedQuestionIdsDataByTopicId($id)
    {
        return \App\Models\Question::whereChapterTopicId($id)->whereIsPublished(1)->pluck('id');
    }
}
if (!function_exists('getSingleQuestionDataByTopicId')) {
    function getSingleQuestionDataByTopicId($id)
    {
        return \App\Models\Question::whereChapterTopicId($id)->first();
    }
}

if (!function_exists('getSinglePublishedQuestionDataByTopicId')) {
    function getSinglePublishedQuestionDataByTopicId($id)
    {
        return \App\Models\Question::whereChapterTopicId($id)->whereIsPublished(1)->first();
    }
}

// if(!function_exists('getQuestionDataBySubjectAndChapterAndTopicId')){
//     function getQuestionDataBySubjectAndChapterAndTopicId($sub_id,$c_id,$t_id){
//         return \App\Models\Question::whereSubjectId($sub_id)->whereSubjectChapterId($c_id)->whereChapterTopicId($t_id)->get();
//     }
// }

if (!function_exists('getVideoDataBySubjectId')) {
    function getVideoDataBySubjectId($id)
    {
        return \App\Models\SubjectVideo::whereSubjectId($id)->get();
    }
}
if (!function_exists('getPendingQuestions')) {
    function getPendingQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $pending_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(0)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
            $pending_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(0)->whereUserId(\Auth::id())->get();
        } elseif (isReviewer(\Auth::id())) {
            $pending_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(0)->whereReviewerId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $pending_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(2)->whereReviewerId(\Auth::id())->get();
        } else {
            $pending_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(0)->get();
        }
        return $pending_ques;
    }
}
if (!function_exists('getApprovedQuestions')) {
    function getApprovedQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(1)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(1)->whereUserId(\Auth::id())->get();
        } elseif (isReviewer(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(1)->whereReviewerId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(1)->whereTypistId(\Auth::id())->get();
        } else {
             $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(1)->get();
        }
        return $approved_ques;
    }
}
if (!function_exists('getVerifiedQuestions')) {
    function getVerifiedQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(5)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
             $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(5)->whereUserId(\Auth::id())->get();
        } elseif (isReviewer(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(5)->whereReviewerId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(5)->whereTypistId(\Auth::id())->get();
        } else {
             $approved_ques = \App\Models\Question::whereIsPublished(0)->whereStatus(5)->get();
        }

        return $approved_ques;
    }
}
if (!function_exists('getPublishedQuestions')) {
    function getPublishedQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(1)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
             $approved_ques = \App\Models\Question::whereIsPublished(1)->whereUserId(\Auth::id())->get();
        } elseif (isReviewer(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(1)->whereReviewerId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $approved_ques = \App\Models\Question::whereIsPublished(1)->whereTypistId(\Auth::id())->get();
        } else {
             $approved_ques = \App\Models\Question::whereIsPublished(1)->get();
        }

        return $approved_ques;
    }
}
if (!function_exists('getNeedCorrectionQuestions')) {
    function getNeedCorrectionQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $need_correction = \App\Models\Question::whereIsPublished(0)->whereStatus(2)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
            $need_correction = \App\Models\Question::whereIsPublished(0)->whereStatus(2)->whereUserId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $need_correction = \App\Models\Question::whereIsPublished(0)->whereStatus(2)->whereTypistId(\Auth::id())->latest()->get();
        } elseif (isReviewer(\Auth::id())) {
            $need_correction = \App\Models\Question::whereIsPublished(0)->whereStatus(1)->whereReviewerId(\Auth::id())->get();
        } else {
            $need_correction = \App\Models\Question::whereIsPublished(0)->whereStatus(2)->get();
        }
        return $need_correction;
    }
}

if (!function_exists('getConfirmationNeededQuestions')) {
    function getConfirmationNeededQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $confirmation_needed = \App\Models\Question::whereIsPublished(0)->whereStatus(3)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
            $confirmation_needed = \App\Models\Question::whereIsPublished(0)->whereStatus(3)->whereUserId(\Auth::id())->get();
        } elseif (isReviewer(\Auth::id())) {
            $confirmation_needed = \App\Models\Question::whereIsPublished(0)->whereStatus(3)->whereReviewerId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $confirmation_needed = \App\Models\Question::whereIsPublished(0)->whereStatus(3)->whereTypistId(\Auth::id())->get();
        } else {
            $confirmation_needed = \App\Models\Question::whereIsPublished(0)->whereStatus(3)->get();
        }
        return $confirmation_needed;
    }
}

if (!function_exists('getConfirmedQuestions')) {
    function getConfirmedQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $confirmed = \App\Models\Question::whereIsPublished(0)->whereStatus(4)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
            $confirmed = \App\Models\Question::whereIsPublished(0)->whereStatus(4)->whereUserId(\Auth::id())->get();
        } elseif (isReviewer(\Auth::id())) {
            $confirmed = \App\Models\Question::whereIsPublished(0)->whereStatus(5)->whereReviewerId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $confirmed = \App\Models\Question::whereIsPublished(0)->whereStatus(5)->whereTypistId(\Auth::id())->get();
        } else {
            $confirmed = \App\Models\Question::whereIsPublished(0)->whereStatus(1)->get();
        }
        return $confirmed;
    }
}

if (!function_exists('getCorrectionFromReviewers')) {
    function getCorrectionFromReviewers()
    {
        if (isTeacher(\Auth::id())) {
            $correction_from_reviewer = \App\Models\Question::whereIsPublished(0)->whereStatus(6)->whereTeacherId(\Auth::id())->get();
        } else {
            $correction_from_reviewer = \App\Models\Question::whereIsPublished(0)->whereStatus(6)->get();
        }
        return $correction_from_reviewer;
    }
}
if (!function_exists('getAllQuestions')) {
    function getAllQuestions()
    {
        if (isTeacher(\Auth::id())) {
            $all_ques = \App\Models\Question::whereIsPublished(1)->whereTeacherId(\Auth::id())->get();
        } elseif (isAssistant(\Auth::id())) {
            $all_ques = \App\Models\Question::whereIsPublished(0)->whereUserId(\Auth::id())->get();
        } elseif (isReviewer(\Auth::id())) {
            $all_ques = \App\Models\Question::whereIsPublished(0)->whereReviewerId(\Auth::id())->get();
        } elseif (isTypist(\Auth::id())) {
            $all_ques = \App\Models\Question::whereIsPublished(0)->whereTypistId(\Auth::id())->get();
        } elseif (isAdmin(\Auth::id())) {
            $all_ques = \App\Models\Question::all();
        } else {
            $all_ques = \App\Models\Question::all();
        }
        return $all_ques;
    }
}

if (!function_exists('getConfirmationNeededAndPendingQuestions')) {
    function getConfirmationNeededAndPendingQuestions()
    {
        if (isAdmin(\Auth::id())) {
            $confirmation_needed = \App\Models\Question::whereIsPublished(0)->whereStatus(3)->whereStatus(0)->get();
        }
        return $confirmation_needed;
    }
}

if (!function_exists('getQuestionStatusById')) {
    function getQuestionStatusById($id)
    {
        if ($id == 0) {
            // Teacher [For Writing Answer]
            return ['name'=>"Pending",'color'=>'danger'];
        }
        if ($id == 1) {
            // Reviewer [For Confirming/Verifing Question]
            return ['name'=>"Answered",'color'=>'warning'];
        }
        if ($id == 2) {
            // Typist [For Typing Answer]
            return ['name'=>"Pending with Typist ",'color'=>'secondary'];
        }
        if ($id == 3) {
            // Teacher [For Approving Answer]
            return ['name'=>"Need Confirmation",'color'=>'primary'];
        }
        if ($id == 4) {
            //
            return ['name'=>"Confirmed",'color'=>'info'];
        }
        if ($id == 5) {
            // Assistant [Verified by Reviewer and ready to Publish]
            // return ['name'=>"Verified",'color'=>'success'];
            return ['name'=>"Reviewed",'color'=>'success'];
        }
        if ($id == 6) {
            // Reviewer [Reject Question]
            // return ['name'=>"Verified",'color'=>'success'];
            return ['name'=>"Correction from Reviewer",'color'=>'info'];
        }
    }
}
// if(!function_exists('getQuestionStatusById')){
//     function getQuestionStatusById($id){
//         if($id == 0){
//             // Teacher [For Writing Answer]
//             return ['name'=>"Pending",'color'=>'danger'];
//         }
//         if($id == 1){
//             // Reviewer [For Confirming/Verifing Question]
//             // return ['name'=>"Approved",'color'=>'warning'];
//             return ['name'=>"Answered",'color'=>'warning'];
//         }
//         if($id == 2){
//             // Typist [For Typing Answer]
//             // return ['name'=>"Need Correction",'color'=>'secondary'];
//             return ['name'=>"Typing/Pending with Typist ",'color'=>'secondary'];
//         }
//         if($id == 3){
//             // Teacher [For Approving Answer]
//             return ['name'=>"Need Confirmation",'color'=>'primary'];
//         }
//         if($id == 4){
//             //
//             return ['name'=>"Confirmed",'color'=>'info'];
//         }
//         if($id == 5){
//             // Assistant [Verified by Reviewer and ready to Publish]
//             // return ['name'=>"Verified",'color'=>'success'];
//             return ['name'=>"Reviewed",'color'=>'success'];
//         }
//     }
// }
if (!function_exists('getStatusData')) {
    function getStatusData()
    {
        return [
            ['name'=>"Unpublish",'id'=>'0'],
            ['name'=>"Publish",'id'=>'1']
        ];
    }
}

if (!function_exists('getBlogCategory')) {
    function getBlogCategory()
    {
        return [
            ['name'=>"Exam Preperation",'id'=>'1'],
            ['name'=>"Other",'id'=>'2']
        ];
    }
}

if (!function_exists('getFaqCategory')) {
    function getFaqCategory()
    {
        return [
            ['name'=>"Help",'id'=>'1'],
            ['name'=>"Refund",'id'=>'2'],
            ['name'=>"Other",'id'=>'3']
        ];
    }
}

if (!function_exists('getFaqCategoryById')) {
    function getFaqCategoryById($id)
    {
        if ($id == 1) {
            return "Help";
        }
        if ($id == 2) {
            return "Refund";
        }
        if ($id == 3) {
            return "Other";
        }
    }
}

if (!function_exists('getGenderData')) {
    function getGenderData()
    {
        return [
            ['name'=>"Male",'id'=>'0'],
            ['name'=>"Female",'id'=>'1'],
            ['name'=>"Other",'id'=>'2']
        ];
    }
}

// if(!function_exists('getSubjectVideoType')){
//     function getSubjectVideoType(){
//         return [
//             ['id'=>1,"name"=>"Youtube Link"],
//             ['id'=>2,"name"=>"Google Link"],
//             ['id'=>3,"name"=>"PG"]
//         ];
//     }
// }
if (!function_exists('getSubjectVideoType')) {
    function getSubjectVideoType($id = -1)
    {
        if ($id == -1) {
            return [
                ['id'=>1,"name"=>'Youtube Link'],
                ['id'=>2,"name"=>'Google Link'],
                ['id'=>3,"name"=>'PG'],
            ];
        } else {
            foreach (getSubjectVideoType() as $row) {
                if ($id==$row['id']) {
                    return $row;
                }
            }
            return ['id'=>0,"name"=>''];
        }
    }
}

if (!function_exists('getUsernameById')) {
    function getUsernameById($id)
    {
        return \App\User::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getUserDataById')) {
    function getUserDataById($id)
    {
        return \App\User::whereId($id)->first();
    }
}

if (!function_exists('checkAndCreateDir')) {
    function checkAndCreateDir($path)
    {
        // Create directory if not exist
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }
}

if (!function_exists('fileExists')) {
    function fileExists($path)
    {
        return File::exists($path);
    }
}

if (!function_exists('getArticleImage')) {
    function getArticleImage($path)
    {
        return asset("storage/uploads/images/article/$path");
    }
}

if (!function_exists('getUniversityImage')) {
    function getUniversityImage($path)
    {
        return asset("storage/uploads/images/university/$path");
    }
}
if (!function_exists('getQuestionImage')) {
    function getQuestionImage($path)
    {
        return asset("storage/uploads/images/question/".$path);
    }
}
if (!function_exists('getQuestionTempImage')) {
    function getQuestionTempImage($path)
    {
        return asset("storage/uploads/images/temp/".$path);
    }
}

if (!function_exists('getUniversityData')) {
    function getUniversityData()
    {
        return App\Models\University::get();
    }
}

if (!function_exists('getUniversityDataForFooter')) {
    function getUniversityDataForFooter()
    {
        return App\Models\University::take(7)->latest()->get();
    }
}
if (!function_exists('getBranchDataForFooter')) {
    function getBranchDataForFooter()
    {
        return App\Models\Branch::groupBy('name')->take(7)->latest()->get();
    }
}
if (!function_exists('getUniversitySemesterTypeById')) {
    function getUniversitySemesterTypeById($id)
    {
        return App\Models\University::whereId($id)->first()->semester_type ?? "numeric";
    }
}
if (!function_exists('getStateData')) {
    function getStateData($c_id = null)
    {
        if ($c_id != null) {
            return App\State::whereCountryId($c_id)->get();
        }
        return App\State::get();
    }
}
if (!function_exists('getCourseData')) {
    function getCourseData()
    {
        return App\Models\TestPaper::get();
    }
}
if (!function_exists('getPendingQuestionCountByTypistId')) {
    function getPendingQuestionCountByTypistId($id)
    {
        return App\Models\Question::whereTypistId($id)->whereStatus(2)->whereIsPublished(0)->get()->count();
    }
}


if (!function_exists('getApprovedQuestionCountByTypistId')) {
    function getApprovedQuestionCountByTypistId($id)
    {
        return App\Models\Question::whereTypistId($id)->whereStatus(5)->whereIsPublished(1)->get()->count();
    }
}

if (!function_exists('getTotalQuestionCountByAssistantId')) {
    function getTotalQuestionCountByAssistantId($id)
    {
        return App\Models\Question::whereUserId($id)->get()->count();
    }
}

if (!function_exists('getPublishedQuestionCountByAssistantId')) {
    function getPublishedQuestionCountByAssistantId($id)
    {
        return App\Models\Question::whereUserId($id)->whereIsPublished(1)->get()->count();
    }
}

if (!function_exists('getTotalQuestionCountByFacultyId')) {
    function getTotalQuestionCountByFacultyId($id)
    {
        return App\Models\Question::whereTeacherId($id)->whereStatus(0)->whereIsPublished(0)->get()->count();
    }
}

if (!function_exists('getPublishedQuestionCountByFacultyId')) {
    function getPublishedQuestionCountByFacultyId($id)
    {
        return App\Models\Question::whereTeacherId($id)->whereIsPublished(1)->get()->count();
    }
}

if (!function_exists('getTotalQuestionCountByReviewerId')) {
    function getTotalQuestionCountByReviewerId($id)
    {
        return App\Models\Question::whereReviewerId($id)->whereStatus(1)->whereIsPublished(0)->get()->count();
    }
}

if (!function_exists('getRejectedQuestionCountByReviewerId')) {
    function getRejectedQuestionCountByReviewerId($id)
    {
        return App\Models\Question::whereReviewerId($id)->whereStatus(6)->whereIsPublished(0)->get()->count();
    }
}

if (!function_exists('getApprovedQuestionCountByReviewerId')) {
    function getApprovedQuestionCountByReviewerId($id)
    {
        return App\Models\Question::whereReviewerId($id)->whereStatus(5)->whereIsPublished(0)->get()->count();
    }
}

if (!function_exists('getPublishedQuestionCountByReviewerId')) {
    function getPublishedQuestionCountByReviewerId($id)
    {
        return App\Models\Question::whereReviewerId($id)->whereIsPublished(1)->get()->count();
    }
}

if (!function_exists('getRealCoursesData')) {
    function getRealCoursesData()
    {
        return App\Models\Course::get();
    }
}
if (!function_exists('getRealCoursesDataByUniversityId')) {
    function getRealCoursesDataByUniversityId($id)
    {
        $data = getUniversityDataById($id);
        return App\Models\Course::whereIn('id', json_decode($data->courses))->get();
    }
}
if (!function_exists('getRealCourseNamebyId')) {
    function getRealCourseNamebyId($id)
    {
        return App\Models\Course::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getStudentsByTestPaperId')) {
    function getStudentsByTestPaperId($id)
    {
        return \App\Models\UserCourse::whereTestPaperId($id)->get()->pluck('user_id');
    }
}
if (!function_exists('getVideoNameById')) {
    function getVideoNameById($id)
    {
        return \App\Models\Video::whereId($id)->first()->name ?? "Video Deleted";
    }
}
if (!function_exists('getArticleNameById')) {
    function getArticleNameById($id)
    {
        return \App\Models\Article::whereId($id)->first()->name ?? "Article Deleted";
    }
}
if (!function_exists('getExamTypeData')) {
    function getExamTypeData()
    {
        return App\Models\ExamType::get();
    }
}
if (!function_exists('getExamTypeNameById')) {
    function getExamTypeNameById($id)
    {
        return App\Models\ExamType::whereId($id)->first()->name ?? "N/A";
    }
}
if (!function_exists('getBranchData')) {
    function getBranchData($p_o_id = null, $u_id = null)
    {
        if ($p_o_id != null && $u_id != null) {
            return App\Models\Branch::whereProgramOfferedId($p_o_id)->whereUniversityId($u_id)->get();
        } else {
            return App\Models\Branch::get();
        }
    }
}

if (!function_exists('getBranchForUser')) {
    function getBranchForUser()
    {
        return App\Models\Branch::groupBy('name')->get();
    }
}
if (!function_exists('getProgramOfferedData')) {
    function getProgramOfferedData()
    {
        return App\Models\ProgramOffered::get();
    }
}
if (!function_exists('getProgramOfferedByCourseId')) {
    function getProgramOfferedByCourseId($id)
    {
        $courseData = App\Models\ProgramOffered::whereCourseId($id)->get();
        if ($courseData->count() > 0) {
            return  $courseData;
        } else {
            return null;
        }
    }
}

if (!function_exists('getProgramNameById')) {
    function getProgramNameById($id)
    {
        return App\Models\ProgramOffered::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getProgramData')) {
    function getProgramData()
    {
        return App\Models\ProgramOffered::get();
    }
}
if (!function_exists('getBranchCourseData')) {
    function getBranchCourseData($id)
    {
        return App\Models\Course::whereBranchId($id)->get();
    }
}
if (!function_exists('getSemesterData')) {
    function getSemesterData()
    {
        return App\Models\Semester::get();
    }
}
if (!function_exists('getSemesterDataByYearId')) {
    function getSemesterDataByYearId($id)
    {
        return App\Models\Semester::whereYearId($id)->get();
    }
}
if (!function_exists('getSemesterDataBySemesterId')) {
    function getSemesterDataBySemesterId($id)
    {
        return App\Models\Semester::whereId($id)->first();
    }
}
if (!function_exists('getQuestionConversationsById')) {
    function getQuestionConversationsById($id)
    {
        return App\Models\UserQuestionLog::whereQuestionId($id)->get();
    }
}
if (!function_exists('getSemesterDataByTypeId')) {
    function getSemesterDataByTypeId($type)
    {
        if ($type == "roman" || $type == "Roman") {
            return App\Models\Semester::get(['in_roman AS name', 'id']);
        } else {
            return App\Models\Semester::get(['in_numeric AS name', 'id']);
        }
    }
}

if (!function_exists('getSemesterNameById')) {
    function getSemesterNameById($id, $u_id)
    {
        $u_data = getUniversityDataById($u_id);
        if ($u_data->semester_type == "numeric") {
            return App\Models\Semester::whereId($id)->first()->in_numeric ?? "Deleted";
        } else {
            return App\Models\Semester::whereId($id)->first()->in_roman ?? "Deleted";
        }
    }
}
if (!function_exists('getYearData')) {
    function getYearData()
    {
        return App\Models\Year::get();
    }
}
if (!function_exists('getYearById')) {
    function getYearById($id)
    {
        return App\Models\Year::whereId($id)->first()->year ?? "N/A";
    }
}
if (!function_exists('getYearNameById')) {
    function getYearNameById($id)
    {
        return App\Models\Year::whereId($id)->first()->year ?? "N/A";
    }
}
if (!function_exists('getTestPaperData')) {
    function getTestPaperData()
    {
        if (isAssistant(Auth::id())) {
            return App\Models\TestPaper::whereUserId(Auth::id())->get();
        } else {
            return App\Models\TestPaper::get();
        }
    }
}
if (!function_exists('getCourseSubjectData')) {
    function getCourseSubjectData()
    {
        return App\Models\CourseSubject::get();
    }
}

if (!function_exists('getCourseSubjectDataById')) {
    function getCourseSubjectDataById($id)
    {
        return App\Models\CourseSubject::whereCourseId($id)->get();
    }
}

if (!function_exists('getCourseSubjectDataBySubjectId')) {
    function getCourseSubjectDataBySubjectId($id)
    {
        return App\Models\CourseSubject::whereId($id)->first();
    }
}

if (!function_exists('MyCourses')) {
    function MyCourses($id = null)
    {
        if ($id == null) {
            $id = \Auth::id();
        }
        return \App\Models\UserCourse::whereUserId($id)->get();
    }
}
if (!function_exists('getTestPaperNameById')) {
    function getTestPaperNameById($id)
    {
        return App\Models\TestPaper::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getCountryData')) {
    function getCountryData()
    {
        return App\Country::get();
    }
}
if (!function_exists('getCityData')) {
    function getCityData($s_id = null)
    {
        if ($s_id != null) {
            return App\City::whereStateId($s_id)->get();
        }
        return App\City::get();
    }
}

if (!function_exists('getChapterTopic')) {
    function getChapterTopic($ch_id = null)
    {
        if ($ch_id != null) {
            return App\Models\ChapterTopic::whereChapterId($ch_id)->get();
        }
        return App\Models\ChapterTopic::get();
    }
}
if (!function_exists('getUniversityNameById')) {
    function getUniversityNameById($id)
    {
        return App\Models\University::whereId($id)->first()->name ?? "--";
    }
}

if (!function_exists('getSubjectChaptersequence')) {
    function getSubjectChaptersequence($id)
    {
        return App\Models\SubjectChapter::whereId($id)->first()->sequence ?? "0";
    }
}

if (!function_exists('getChapterTopicSequence')) {
    function getChapterTopicSequence($id)
    {
        return App\Models\ChapterTopic::whereId($id)->first()->sequence ?? "0";
    }
}

if (!function_exists('getUniversityByCourseId')) {
    function getUniversityByCourseId($id_arr)
    {

        return App\Models\University::where('courses', 'like', '%' . $id_arr . '%')->get();
    }
}
if (!function_exists('getUniversityDataById')) {
    function getUniversityDataById($id)
    {
        return App\Models\University::whereId($id)->first();
    }
}
if (!function_exists('getBranchNameById')) {
    function getBranchNameById($id)
    {
        return App\Models\Branch::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getCollegeNameById')) {
    function getCollegeNameById($id)
    {
        return App\Models\College::whereId($id)->first()->name ?? "--";
    }
}
if (!function_exists('getCourseNameById')) {
    function getCourseNameById($id)
    {
        return App\Models\Course::whereId($id)->first()->name ?? "Deleted";
    }
}
if (!function_exists('getStatusColorById')) {
    function getStatusColorById($id)
    {
        if ($id == 0) {
            return "danger";
        }
        if ($id == 1) {
            return "success";
        }
        if ($id == 2) {
            return "info";
        }
    }
}
if (!function_exists('getInvoiceStatusById')) {
    function getInvoiceStatusById($id = -1)
    {
        if ($id == -1) {
            return [
                ["id"=>"0","name"=>'Pending',"color"=>'secondary'],
                ["id"=>"1","name"=>'Accepted',"color"=>'success'],
                ["id"=>"2","name"=>'Rejected Out',"color"=>'danger'],
                ];
        } else {
            foreach (getInvoiceStatusById() as $row) {
                if ($id == $row['id']) {
                    return $row;
                }
            }
            return ["id"=>'',"name"=>' ','color'=>' '];
        }
    }
}
if (!function_exists('getStatus')) {
    function getStatus()
    {
        return [
            ['id'=>1,"name"=>"Published"],
            ['id'=>0,"name"=>"Unpublished"],
        ];
    }
}

if (!function_exists('getOrderStatus')) {
    function getOrderStatus($id = -1)
    {
        if ($id != -1) {
            if ($id == 0) {
                return "Unpaid";
            }
            if ($id == 1) {
                return "Paid";
            }
            if ($id == 2) {
                return "Cancelled";
            }
        } else {
            return  [
                ['id'=>0,"name"=>"Unpaid"],
                ['id'=>1,"name"=>"Paid"],
                ['id'=>2,"name"=>"Cancelled"],
            ];
        }
    }
}

if (!function_exists('getorderStatusColorById')) {
    function getorderStatusColorById($id)
    {
        if ($id == 0) {
            return "warning";
        }
        if ($id == 1) {
            return "success";
        }
        if ($id == 2) {
            return "info";
        }
        return "";
    }
}

if (!function_exists('getWalletStatus')) {
    function getWalletStatus($id)
    {
        if ($id == 0) {
            return "Unpaid";
        }
        if ($id == 1) {
            return "Paid";
        }
    }
}

if (!function_exists('getWalletStatusColorById')) {
    function getWalletStatusColorById($id)
    {
        if ($id == 0) {
            return "danger";
        }
        if ($id == 1) {
            return "success";
        }
    }
}


if (!function_exists('getUserPayoutStatus')) {
    function getUserPayoutStatus($id)
    {
        if ($id == 0) {
            return "Paid";
        }
        if ($id == 1) {
            return "Unpaid";
        }
    }
}

if (!function_exists('getUserPayoutStatusColorById')) {
    function getUserPayoutStatusColorById($id)
    {
        if ($id == 0) {
            return "success";
        }
        if ($id == 1) {
            return "danger";
        }
    }
}

if (!function_exists('getBranchType')) {
    function getBranchType()
    {
        return [
            ['id'=>1,"name"=>"Diploma"],
            ['id'=>2,"name"=>"UG"],
            ['id'=>3,"name"=>"PG"]
        ];
    }
}

if (!function_exists('getCourseType')) {
    function getCourseType()
    {
        return [
            ['id'=>1,"name"=>"Diploma"],
            ['id'=>2,"name"=>"UG"],
            ['id'=>3,"name"=>"PG"]
        ];
    }
}
if (!function_exists('getSemesterTypeData')) {
    function getSemesterTypeData()
    {
        return [
            ['id'=>1,"name"=>"Numeric"],
            ['id'=>2,"name"=>"Roman"]
        ];
    }
}
if (!function_exists('getQuestionTypes')) {
    function getQuestionTypes($id = -1)
    {
        if ($id == -1) {
            return [
                ['id'=>1, "name"=>"Short"],
                ['id'=>2, "name"=>"Long"]
            ];
        } else {
            foreach (getQuestionTypes() as $row) {
                if ($id == $row['id']) {
                    return $row;
                }
            }
            return ['id'=>0,'name'=>''];
        }
    }
}

if (!function_exists('getQuestionTypesById')) {
    function getQuestionTypesById($id)
    {
        $arr =  [
            ['id'=>1,"name"=>"Short"],
            ['id'=>2,"name"=>"Long"]
        ];
        foreach ($arr as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
    }
}
if (!function_exists('getBranchTypeById')) {
    function getBranchTypeById($id)
    {
        $arr = getBranchType();
        foreach ($arr as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
    }
}

if (!function_exists('getCourseTypeById')) {
    function getCourseTypeById($id)
    {
        $arr = getCourseType();
        foreach ($arr as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
    }
}

if (!function_exists('getSubjectsByBranchId')) {
    function getSubjectsByBranchId($id)
    {
        return App\Models\CourseSubject::whereBranchId($id)->get();
    }
}
if (!function_exists('getCollegeByUniversityId')) {
    function getCollegeByUniversityId($id)
    {
        return App\Models\College::whereUniversityId($id)->get();
    }
}
if (!function_exists('getBranchByCourseAndUniversityId')) {
    function getBranchByCourseAndUniversityId($u_id, $c_id, $program_id)
    {
        if ($program_id != null) {
            return App\Models\Branch::whereUniversityId($u_id)
            ->whereCourseId($c_id)
            ->whereProgramOfferedId($program_id)->get();
        }
        return App\Models\Branch::whereCourseId($c_id)->get();
    }
}
if (!function_exists('getBranchByUniversityId')) {
    function getBranchByUniversityId($id, $program_id = null)
    {
        if ($program_id != null) {
            return App\Models\Branch::whereUniversityId($id)->whereProgramOfferedId($program_id)->get();
        }
        return App\Models\Branch::whereUniversityId($id)->get();
    }
}
if (!function_exists('getBranchByUniversityAndProgramAndCourseId')) {
    function getBranchByUniversityAndProgramAndCourseId($id, $program_id, $c_id)
    {
           return App\Models\Branch::whereUniversityId($id)->whereProgramOfferedId($program_id)->whereCourseId($c_id)->get();
    }
}
if (!function_exists('getProgramByCourseId')) {
    function getProgramByCourseId($id)
    {
        return App\Models\ProgramOffered::whereCourseId($id)->get();
    }
}
if (!function_exists('getEbookPdfPath')) {
    function getEbookPdfPath($path)
    {
        return asset('storage/uploads/ebooks/'.$path);
    }
}
if (!function_exists('getStatusNameById')) {
    function getStatusNameById($id)
    {
        $arr = [
            ['id'=>1,"name"=>"Published"],
            ['id'=>0,"name"=>"Unpublished"],
        ];

        foreach ($arr as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
    }
}

if (!function_exists('getOrderStatusNameById')) {
    function getOrderStatusNameById($id)
    {
        $arr = [
            ['id'=>0,"name"=>"Pending"],
            ['id'=>1,"name"=>"Completed"],
            ['id'=>2,"name"=>"Cancelled"],
        ];

        foreach ($arr as $item) {
            if ($item['id'] == $id) {
                return $item['name'];
            }
        }
    }
}

// if(!function_exists('getCourseStudentsById')){
//     function getCourseStudentsById($id){
//      return \App\Models\TestUser::whereCourseId($id)->get()->pluck('user_id');
//     }
// }

if (!function_exists('getTestPaperStudentsById')) {
    function getTestPaperStudentsById($id)
    {
        return \App\Models\UserCourse::whereTestPaperId($id)->get()->pluck('user_id');
    }
}

if (!function_exists('getTestPaperDataById')) {
    function getTestPaperDataById($id)
    {
        return \App\Models\TestPaper::whereId($id)->first();
    }
}


// for ebook collection count
if (!function_exists('getEbookById')) {
    function getEbookById($id)
    {
        return \App\Models\EbookChild::whereEbookId($id)->get();
    }
}

if (!function_exists('getStateNameById')) {
    function getStateNameById($id)
    {
        return App\State::whereId($id)->first()->name ?? " ";
    }
}
if (!function_exists('getCityNameById')) {
    function getCityNameById($id)
    {
        return App\City::whereId($id)->first()->name ?? " ";
    }
}
if (!function_exists('getCountryNameById')) {
    function getCountryNameById($id)
    {
        return App\Country::whereId($id)->first()->name ?? " ";
    }
}
if (!function_exists('NameById')) {
    function NameById($id)
    {
        return App\User::whereId($id)->first()->name ?? " ";
    }
}

if (!function_exists('getCollegeData')) {
    function getCollegeData()
    {
        return App\Models\College::get();
    }
}
if (!function_exists('getCollegeDataForFooter')) {
    function getCollegeDataForFooter()
    {
        return App\Models\College::take(7)->latest()->get();
    }
}
if (!function_exists('getCoursesData')) {
    function getCoursesData()
    {
        return App\Models\Course::get();
    }
}

if (!function_exists('selectSelecter')) {
    function selectSelecter($old_val, $updated_val, $compare_val)
    {
        if ($old_val != null) {
            $result = $old_val == $compare_val ? "selected" : '';
        } elseif ($updated_val != null) {
            $result = $updated_val == $compare_val ? "selected" : '';
        } else {
            $result = '';
        }
        return $result;
    }
}


if (!function_exists('getAllEbookChildrenProgressByUserId')) {
    function getAllEbookChildrenProgressByUserId($u_id, $c_id)
    {
        return \App\Models\EbookChildUser::whereUserId($u_id)->whereCourseId($c_id)->get();
    }
}

if (!function_exists('TemplateMail')) {
    function TemplateMail($name, $code, $to, $mail_type, $arr, $mailcontent_data, $mail_footer, $action_button = null)
    {

        $to = $to;
        $data['name'] = $name;
        $name = $name;
        $data['subject'] = $mailcontent_data->subject;
        $subject = $mailcontent_data->subject;
        $data['type_id'] = $mail_type;
        $type_id = $mail_type;
        $chk_data = $mailcontent_data;
        $data['t_footer'] = $mail_footer;

        $t_data =  DynamicMailTemplateFormatter($chk_data->body, $chk_data->variable_names, $arr);
        $data['t_data'] = $t_data;
        $data['action_button'] = $action_button;

        // Mail Sender
        \Mail::send('backend.emails.dynamic-custom', $data, function ($message) use ($to, $name, $subject) {
            $message->to($to, $name)->subject($subject);
            $message->from('d3mo.mail404@gmail.com', 'SemesterPrep');
        });
        return true;
    }
}
if (!function_exists('DynamicMailTemplateFormatter')) {
    function DynamicMailTemplateFormatter($body, $variable_names, $var_list)
    {

        // Make it Foreachable
        $variable_names = explode(', ', $variable_names);
        $i = 1;
        foreach ($variable_names as $item) {
            if ($i == 1) {
                $data =  str_replace($item, $var_list[$item], $body);
                $i += 1;
            } else {
                $data =  str_replace($item, $var_list[$item], $data);
            }
        }
        return $data;
    }
}

if (!function_exists('fetchFirst')) {
    function fetchFirst($model, $id, $col = null, $default = '')
    {
        if ($col != null) {
            return    $model::whereId($id)->first()->$col ?? $default;
        } else {
            return    $model::whereId($id)->first();
        }
    }
}

if (!function_exists('isLiveClassReaded')) {
    function isLiveClassReaded($l_c_id, $user_id)
    {
        return \App\Models\LiveClassUser::whereClassId($l_c_id)->whereUserId($user_id)->first();
    }
}

if (!function_exists('getClassHandoutPath')) {
    function getClassHandoutPath($path)
    {
        return asset('storage/uploads/handouts/'.$path);
    }
}

if (!function_exists('getClassesByCourseId')) {
    function getClassesByCourseId($c_id)
    {
        return \App\Models\Classes::whereCourseId($c_id)->where('date', '>=', \Carbon\Carbon::today())->get();
    }
}

if (!function_exists('getPastClassesByCourseId')) {
    function getPastClassesByCourseId($c_id)
    {
        return \App\Models\Classes::whereCourseId($c_id)->where('date', '<', \Carbon\Carbon::today())->get();
    }
}

if (!function_exists('getContactStatus')) {
    function getContactStatus($id)
    {
        if ($id == 0) {
            return "Pending";
        }
        if ($id == 1) {
            return "Resolved";
        }
        if ($id == 2) {
            return "Cancelled";
        }
    }
}
if (!function_exists('getContactStatusColorById')) {
    function getContactStatusColorById($id)
    {
        if ($id == 0) {
            return "danger";
        }
        if ($id == 1) {
            return "success";
        }
        if ($id == 2) {
            return "warning";
        }
    }
}
if (!function_exists('getContactByStatus')) {
    function getContactByStatus($id)
    {
        return \App\Models\Contact::whereStatus($id)->get();
    }
}


if (!function_exists('getTicketByUserId')) {
    function getTicketByUserId()
    {
        return \App\Models\Contact::whereUserId(\Auth::id())->get();
    }
}

if (!function_exists('getBookmarkQuestionByUserId')) {
    function getBookmarkQuestionByUserId($id)
    {
        return \App\Models\QuestionBookmark::whereUserId($id)->get();
    }
}
if (!function_exists('checkBookmarkQuestionByQuestionIdAndType')) {
    function checkBookmarkQuestionByQuestionIdAndType($id, $type)
    {
        return \App\Models\QuestionBookmark::whereUserId(\Auth::id())->whereTypeId($id)->whereType($type)->first();
    }
}
if (!function_exists('getTicket')) {
    function getTicket()
    {
        return \App\Models\Contact::all();
    }
}
if (!function_exists('getProgramDataByCourseId')) {
    function getProgramDataByCourseId($id)
    {
        return \App\Models\ProgramOffered::whereCourseId($id)->get();
    }
}
if (!function_exists('IsProgramHasInCourseId')) {
    function IsProgramHasInCourseId($id, $type)
    {
        return \App\Models\ProgramOffered::whereCourseId($id)->whereName($type)->first();
    }
}
if (!function_exists('getSemesterNameByYearId')) {
    function getSemesterNameByYearId($id, $type)
    {
        return \App\Models\Semester::whereId($id)->first()->$type ?? "Deleted";
    }
}

if (!function_exists('getChapterSequenceById')) {
    function getChapterSequenceById($id)
    {
        return \App\Models\SubjectChapter::whereId($id)->first()->sequence ?? "Deleted";
    }
}

if (!function_exists('haveCourse')) {
    function haveCourse($test_paper_id, $user_id = null)
    {
        if ($user_id == null) {
            $user_id = auth()->id();
        }
        return \App\Models\UserCourse::whereTestPaperId($test_paper_id)->whereUserId($user_id)->first();
    }
}
if (!function_exists('havePurchaseCourse')) {
    function havePurchaseCourse($test_paper_id, $user_id = null)
    {
        if ($user_id == null) {
            $user_id = auth()->id();
        }
        return \App\Models\UserCourse::whereTestPaperId($test_paper_id)
                ->whereUserId($user_id)
                ->whereType(1)
                ->first();
    }
}

if (!function_exists('haveCoursePrivilege')) {
    function haveCoursePrivilege($test_paper_id)
    {
        if ($user_id == null) {
            $user_id = auth()->id();
        }
        $data = haveCourse($test_paper_id);
        if ($data) {
            if ($data->type = 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if (!function_exists('courseUserDataById')) {
    function courseUserDataById($test_paper_id)
    {
        return \App\Models\UserCourse::whereTestPaperId($test_paper_id)->get();
    }
}
if (!function_exists('questionLogWriter')) {
    function questionLogWriter($user_id, $role, $assign_at, $deadline, $question_id, $question, $answer, $comment = null, $assistant_id, $teacher_id, $typist_id, $reviewer_id)
    {
         \App\Models\UserQuestionLog::create([
            'user_id' => $user_id,
            'role'  => $role,
            'assign_at' => $assign_at,
            'deadline' => $deadline,
            'question_id' => $question_id,
            'question' => $question,
            'answer' => $answer ?? 'N/A',
            'comment' => $comment ?? 'N/A',
            'assistant_id' => $assistant_id,
            'teacher_id' => $teacher_id,
            'typist_id' => $typist_id,
            'reviewer_id' => $reviewer_id
         ]);

         return true;
    }
}
if (!function_exists('getUserQuestionLogByQuestionId')) {
    function getUserQuestionLogByQuestionId($id)
    {
        return \App\Models\UserQuestionLog::whereQuestionId($id)->get();
    }
}
if (!function_exists('getDeadlineValue')) {
    function getDeadlineValue()
    {
         return 6;
    }
}
if (!function_exists('unSearchableWordsArray')) {
    function unSearchableWordsArray()
    {
         return [
             'the','is','an','what','or','and','why','which','when','are','if','hi','hey','this','their','there','to','for','from','will','shall','should','would',' a '
         ];
    }
}
if (!function_exists('unSearchableWordsFilter')) {
    function unSearchableWordsFilter($str)
    {
         $temp = $str;
         $words = unSearchableWordsArray();
        foreach ($words as $word) {
            $temp = str_replace(' '.$word.' ', "", $temp);
            // $temp = preg_replace("#{$word}#", "", $temp, 1);
        }
         return $temp;
    }
}
if (!function_exists('getTeacherProofReading')) {
    function getTeacherProofReading()
    {
        $questions = DB::table('user_question_logs')->where('teacher_id', \Auth::id())
        ->select('question_id', DB::raw('count(*) as total'))
        ->havingRaw('COUNT(total) > ?', [3])
        ->groupBy('question_id')
        ->get();
         return $questions;
    }
}
if (!function_exists('getTypistProofReading')) {
    function getTypistProofReading()
    {
        $questions = DB::table('user_question_logs')->where('typist_id', \Auth::id())
        ->select('question_id', DB::raw('count(*) as total'))
        ->havingRaw('COUNT(total) > ?', [3])
        ->groupBy('question_id')
        ->get();
         return $questions;
    }
}
if (!function_exists('getNewRoleNameById')) {
    function getNewRoleNameById($id)
    {
        if ($id == 2) {
            return "Super Admin";
        }
        if ($id == 6) {
            return "Faculty";
        }
        if ($id == 7) {
            return "Uploader";
        }
        if ($id == 8) {
            return "Student";
        }
        if ($id == 9) {
            return "Reviewer";
        }
        if ($id == 10) {
            return "Typist";
        }
        if ($id == 11) {
            return "Admin";
        }
    }
}

// if(!function_exists('deleteQuestionLogs')){
//     function deleteQuestionLogs($id){
//         $question = App\Models\Question::whereId($id)->first();
//         if($question->is_published == 1){
//             $data = App\Models\UserQuestionLog::whereQuestionId($id)->get();
//             if(count($data)>1)
//             {
//                 $data_id= [];
//                 foreach ($data as $i)
//                 {
//                     $data_id[] = $i->id;
//                 }
//                 for($i=0;$i<count($data);$i++)
//                 {
//                     App\Models\UserQuestionLog::find($data_id[$i])->delete();
//                 }
//             }
//             elseif (count($data)==1)
//             {
//                 $data->delete();
//             }
//         }
//     }
// }

if (!function_exists('showLimitedWords')) {
    function showLimitedWords($data)
    {
        $output =  str_replace('&nbsp;', '', Str::words(Strip_tags($data), 20, ' ...'));
        $output =  str_replace('&rsquo;', "'", Str::words(Strip_tags($output), 20, ' ...'));
        $output =  str_replace('\n', '', Str::words(Strip_tags($output), 20, ' ...'));

        return $output;
    }
}

if (!function_exists('getUserTestPaperEnrollCountById')) {
    function getUserTestPaperEnrollCountById($id)
    {
        return \App\Models\UserCourse::whereTestPaperId($id)->get()->count();
    }
}

if (!function_exists('getTestPaperVideoCountBySubjectId')) {
    function getTestPaperVideoCountBySubjectId($id)
    {
        return \App\Models\SubjectVideo::whereSubjectId($id)->get()->count();
    }
}

if (!function_exists('getSubjectVideoLinkById')) {
    function getSubjectVideoLinkById($id)
    {
        return \App\Models\SubjectVideo::whereId($id)->whereIsPublished(1)->first()->link ?? "#";
    }
}
if (!function_exists('getSubjectVideoTitleyId')) {
    function getSubjectVideoTitleyId($id)
    {
        return \App\Models\SubjectVideo::whereId($id)->whereIsPublished(1)->first()->title ?? "Deleted";
    }
}

if (!function_exists('getTotalStudentQuestionProgress')) {
    function getTotalStudentQuestionProgress()
    {
        $question = \App\Models\Question::whereIsPublished(1)->count();
        $progress = \App\Models\StudentQuestionProgress::whereUserId(\Auth::id())->count();
        $question = $question == 0 ? 1 : $question;
        $total_progress = ($progress*100)/$question;
        return $total_progress;
    }
}

if (!function_exists('getTopicStudentQuestionProgress')) {
    function getTopicStudentQuestionProgress($c_id, $s_id, $test_paper_id, $t_id)
    {
        $question = \App\Models\Question::whereSubjectChapterId($c_id)->whereSubjectId($s_id)->whereIsPublished(1)->count();
        $progress = \App\Models\StudentQuestionProgress::whereUserId(\Auth::id())->where('test_paper_id', $test_paper_id)->where('topic_id', $t_id)->count();
        $question = $question == 0 ? 1 : $question;
        $total_progress = ($progress*100)/$question;
        return round($total_progress);
    }
}

if (!function_exists('getTotalStudentVideoProgress')) {
    function getTotalStudentVideoProgress($test_paper_id, $subject_id = null, $topic_id = null)
    {
        $test_paper = App\Models\TestPaper::whereId($test_paper_id)->first();
        if ($subject_id == null && $topic_id == null) {
            $videoids = \App\Models\SubjectVideo::whereIn('subject_id', $test_paper->subjects->pluck('id'))->whereIsPublished(1)->pluck('id');

            $video = $videoids->count();
            $progress = \App\Models\StudentVideoProgress::whereUserId(\Auth::id())->whereIn('subject_video_id', $videoids)->count();
            $video = $video == 0 ? 1 : $video;
            $total_progress = ($progress*100)/$video;
            return round($total_progress, 0);
        } else {
            $subjectId = App\Models\Subject::where('course_subject_id', $subject_id)->first()->id ?? '';
            $topicId = App\Models\ChapterTopic::where('chapter_id', $topic_id)->first()->id  ?? '';
            $videoids = \App\Models\SubjectVideo::where('subject_id', $subjectId)->where('topic_id', $topicId)->whereIsPublished(1)->pluck('id');
            $video = $videoids->count();
            $progress = \App\Models\StudentVideoProgress::whereUserId(\Auth::id())->whereIn('subject_video_id', $videoids)->where('topic_id', $topicId)->count();
            $video = $video == 0 ? 1 : $video;
            $total_progress = ($progress*100)/$video;
            return round($total_progress, 0);
        }
    }
}

if (!function_exists('getTotalStudentProgress')) {
    function getTotalStudentProgress()
    {
        $question = \App\Models\Question::whereIsPublished(1)->get()->count();
        $video = \App\Models\SubjectVideo::whereIsPublished(1)->get()->count();
        $progress1 = \App\Models\StudentVideoProgress::whereUserId(\Auth::id())->get()->count();
        $progress2 = \App\Models\StudentQuestionProgress::whereUserId(\Auth::id())->get()->count();
        $video = $video == 0 ? 1 : $video;
        $question = $question == 0 ? 1 : $question;

        $progress = $progress1 + $progress2;
        $total_question = $question + $video;
        $total_progress = ($progress*100)/$total_question;
        return $total_progress;
    }
}
if (!function_exists('getTotalStudentProgressByTestPaper')) {
    function getTotalStudentProgressByTestPaper($id)
    {
        $test_paper = App\Models\TestPaper::whereId($id)->first();
        $questionids = \App\Models\Question::whereIn('subject_id', $test_paper->subjects->pluck('id'))->whereIsPublished(1)->pluck('id');
        $videoids = \App\Models\SubjectVideo::whereIn('subject_id', $test_paper->subjects->pluck('id'))->whereIsPublished(1)->pluck('id');

        $progress1 = \App\Models\StudentVideoProgress::whereIn('subject_video_id', $videoids)->whereUserId(\Auth::id())->distinct('subject_video_id')->get()->count();
        $progress2 = \App\Models\StudentQuestionProgress::whereIn('question_id', $questionids)->whereUserId(\Auth::id())->distinct('question_id')->get()->count();
        $video = $videoids->count() == 0 ? 1 : $videoids->count();
        $question = $questionids->count() == 0 ? 1 : $questionids->count();

        $progress = $progress1 + $progress2;
        $total_question = $question + $video;
        $total_progress = ($progress*100)/$total_question;
        return round($total_progress);
    }
}

if (!function_exists('getLastVideoByTopicId')) {
    function getLastVideoByTopicId($t_id)
    {
        $chk = \App\Models\StudentVideoProgress::whereUserId(\Auth::id())->whereTopicId($t_id)->latest()->first();
        if ($chk) {
            $test = \App\Models\SubjectVideo::whereId($chk->subject_video_id)->whereIsPublished(1)->first();
            if ($test) {
                return $test->id;
            }
        }
        return \App\Models\SubjectVideo::whereTopicId($t_id)->whereIsPublished(1)->first()->id ?? "404";
    }
}

if (!function_exists('getQuestionRating')) {
    function getQuestionRating($id)
    {
        $products = \App\Models\StudentFeedback::whereTypeId($id)->whereType('Question')->get();
        return [
            'rating'=>round($products->avg('rating'), 1),
            // 'count'=>$products->count()
            'count'=>5
        ];
    }
}


if (!function_exists('getUniqueQuestions')) {
    function getUniqueQuestions($u_id, $c_id = null, $b_id = null, $s_id = null, $ch_id = null, $t_id = null)
    {
        if ($u_id != null && $c_id == null && $b_id == null && $s_id == null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id == null && $s_id == null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id == null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id != null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id != null && $ch_id != null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id != null && $ch_id != null && $t_id != null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', null)->get()->count();
        }
    }
}

if (!function_exists('getNonUniqueQuestions')) {
    function getNonUniqueQuestions($u_id, $c_id = null, $b_id = null, $s_id = null, $ch_id = null, $t_id = null)
    {
        if ($u_id != null && $c_id == null && $b_id == null && $s_id == null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', '!=', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id == null && $s_id == null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', '!=', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id == null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', '!=', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id != null && $ch_id == null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', '!=', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id != null && $ch_id != null && $t_id == null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', '!=', null)->get()->count();
        } elseif ($u_id != null && $c_id != null && $b_id != null && $s_id != null && $ch_id != null && $t_id != null) {
            $testpaper = \App\Models\TestPaper::whereUniversityId($u_id)->get()->pluck('id');
            $subjects = \App\Models\Subject::whereIn('test_paper_id', $testpaper)->get()->pluck('id');
            return \App\Models\Question::whereIn('subject_id', $subjects)->where('related_question', '!=', null)->get()->count();
        }
    }
}

if (!function_exists('getUniqueQuestionsCount')) {
    function getUniqueQuestionsCount()
    {
        return \App\Models\Question::where('related_question', null)->get()->count();
    }
}

if (!function_exists('getNonUniqueQuestionsCount')) {
    function getNonUniqueQuestionsCount()
    {
            return \App\Models\Question::where('related_question', '!=', null)->get()->count();
    }
}

if (!function_exists('getStudentQuestionProgressCountByUserAndDate')) {
    function getStudentQuestionProgressCountByUserAndDate($date)
    {
        return \App\Models\StudentQuestionProgress::whereUserId(\Auth::id())->whereDate('created_at', $date)->get()->count() ?? 0;
    }
}

if (!function_exists('getStudentVideoProgressCountByUserAndDate')) {
    function getStudentVideoProgressCountByUserAndDate($date)
    {
        return \App\Models\StudentVideoProgress::whereUserId(\Auth::id())->whereDate('created_at', $date)->get()->count() ?? 0;
    }
}

if (!function_exists('paragraph_content')) {
    function paragraph_content($code)
    {
        return \App\Models\ParagraphContent::whereCode($code)->first()->content ?? ' ';
    }
}
if (!function_exists('authLoginToUsingAccessCode')) {
    function authLoginToUsingAccessCode($product_id, $user_id, $user_shop)
    {
        return  App\Models\UserShopItem::whereProductId($product_id)->whereUserId($user_id)
                ->whereUserShopId($user_shop)->first();
    }
}

if (!function_exists('deleteBranches')) {
    function deleteBranches($branches, $forceDelete = 1)
    {
        if ($forceDelete == 1) {
            foreach ($branches as $branch) {
                deleteSubjects($branch->subjects);
                $branch->delete();
            }
        } else {
            foreach ($branches as $branch) {
                if ($branch->subjects->count() > 0) {
                    $data['status'] = false;
                    $data['msg'] = "Branch can't deleted!";
                    return $data;
                } else {
                    $branch->delete();
                }
            }
        }
        $data['status'] = true;
        $data['msg'] = "Branch deleted!";
        return $data;
    }
}
if (!function_exists('deleteSubjects')) {
    function deleteSubjects($subjects, $forceDelete = 1)
    {
        if ($forceDelete == 1) {
            foreach ($subjects as $subject) {
                deleteChapters($subject->chapters);
                $subject->delete();
            }
        } else {
            foreach ($subjects as $subject) {
                if ($subject->chapters->count() > 0) {
                    $data['status'] = false;
                    $data['msg'] = "Subject can't deleted!";
                    return $data;
                } else {
                    $subject->delete();
                }
            }
        }
        $data['status'] = true;
        $data['msg'] = "Subject deleted!";
        return $data;
    }
}
if (!function_exists('deleteChapters')) {
    function deleteChapters($chapters, $forceDelete = 1)
    {
        if ($forceDelete == 1) {
            foreach ($chapters as $chapter) {
                deleteTopics($chapter->topics);
                $chapter->delete();
            }
        } else {
            foreach ($chapters as $chapter) {
                if ($chapter->topics->count() > 0) {
                    $data['status'] = false;
                    $data['msg'] = "chapter can't deleted!";
                    return $data;
                } else {
                    $chapter->delete();
                }
            }
        }
        $data['status'] = true;
        $data['msg'] = "Chapter deleted!";
        return $data;
    }
}
if (!function_exists('deleteTopics')) {
    function deleteTopics($topics, $forceDelete = 1)
    {
        if ($forceDelete == 1) {
            foreach ($topics as $topic) {
                \App\Models\Question::where('chapter_topic_id', $topic->id)->delete();
                $topic->delete();
            }
        } else {
            foreach ($topics as $topic) {
                if ($topic->questions->count() > 0) {
                    $data['status'] = false;
                    $data['msg'] = "topic can't deleted!";
                    return $data;
                } else {
                    $topic->delete();
                }
            }
        }
        $data['status'] = true;
        $data['msg'] = "Topic deleted!";
        return $data;
    }
}

if (!function_exists('deleteTestPaper')) {
    function deleteTestPaper($testPapers, $forceDelete = 1)
    {
        if ($forceDelete == 1) {
            foreach ($testPapers as $testPaper) {
                \App\Models\StudentQuestionProgress::where('test_paper_id', $testPaper->id)->delete();
                \App\Models\UserOrder::where('test_id', $testPaper->id)->delete();
                $testPaper->delete();
            }
        } else {
            foreach ($testPapers as $testPaper) {
                $progress = \App\Models\StudentQuestionProgress::where('test_paper_id', $testPaper->id)->get();
                $userOrder = \App\Models\UserOrder::where('test_id', $testPaper->id)->get();
                if ($progress->count() > 0) {
                    $data['status'] = false;
                    $data['msg'] = "Testpapers can't be deleted!";
                    return $data;
                } else {
                    $testPaper->delete();
                }
                if ($userOrder->count() > 0) {
                    $data['status'] = false;
                    $data['msg'] = "Testpapers can't be deleted!";
                    return $data;
                } else {
                    $testPaper->delete();
                }
            }
        }
        $data['status'] = true;
        $data['msg'] = "Testpapers deleted!";
        return $data;
    }
}
if (!function_exists('getUserView')) {
    function getUserView()
    {
        if ((new \Jenssegers\Agent\Agent())->isMobile()) {
            $view = 'Mobile';
        } elseif ((new \Jenssegers\Agent\Agent())->isDesktop()) {
            $view = 'Desktop';
        } elseif ((new \Jenssegers\Agent\Agent())->isTablet()) {
            $view = 'Tablet';
        }
        return $view;
    }
}

if (!function_exists('sendSMS')) {
    function sendSMS($mob, $otp)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://www.fast2sms.com/dev/bulkV2?authorization=q3MZRLSntG9jAFYC85y4wlkrvpd2EciQVPIBbaKh1UuJWHTNXmKgXFQH3vCoyUjlnLkMDOG1JpcY6her&route=q&message=login%2520OTP:%2520'.$otp.'%2520we%2520never%2520call%2520for%2520OTP%250ADo%2520not%2520share%2520it%2520with%2520anyone.&language=english&flash=0&numbers='.$mob,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
if (! function_exists('format_price')) {
    function format_price($price)
    {
        if (App\Models\Setting::where('key', 'decimal_separator')->first()->value == 1) {
            $fomated_price = number_format($price, App\Models\Setting::where('key', 'no_of_decimal')->first()->value);
        } else {
            $fomated_price = number_format($price, App\Models\Setting::where('key', 'no_of_decimal')->first()->value, ',', '.');
        }

        if (App\Models\Setting::where('key', 'currency_position')->first()->value == 1) {
            return getSetting('app_currency').$fomated_price;
        }
        return $fomated_price.getSetting('app_currency');
    }
}
if (!function_exists('getInvoicePrefix')) {
    function getInvoicePrefix($id)
    {
        return '#SPINV'.$id;
    }
}
