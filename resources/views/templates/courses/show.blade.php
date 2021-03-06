<!-- Course info -->
<div>
    <h3><span class="fa fa-info-circle" aria-hidden="true"></span> 課程資訊</h3><br>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="row text-center">
                <courses-info icon="fa-university" type="開課系所" value="@{{ info.department.name }}"></courses-info>

                <courses-info icon="fa-file-text" type="課程名稱" value="@{{ info.name }}"></courses-info>

                <courses-info icon="fa-user" type="授課教授" value="@{{ info.professor }}"></courses-info>
            </div>
        </div>
    </div>
</div>

<!-- Course comments -->
<div ng-controller="CoursesCommentsController">
    <h3><span><span class="fa fa-comments" aria-hidden="true"></span> 課程評論</span></h3><br>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 col-sm-7 col-sm-offset-1">
            <div ng-if="$root.user.signIn && comment.showReply">
                <form>
                    <fieldset>
                        <div class="form-group">
                            <label for="course-comments-textarea" class="sr-only">留言</label>
                            <textarea ng-model="comment.content" tbio configuration="ccu" tbio-required tbio-minlength="10" tbio-maxlength="2500" rows="12"></textarea>
                        </div>

                        <div class="form-group text-right">
                            <label>{!! Form::checkbox('anonymous', true, null, ['ng-model' => 'comment.anonymous']) !!} <span>匿名</span></label>

                            <button ng-disabled=" ! comment.content" ng-click="commentFormSubmit()" class="btn btn-sm btn-success">留言</button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div ng-hide="comments.data.length" class="text-center">
                <h3 class="text-muted">尚無留言</h3>
            </div>

            <div ng-if="comments.data.length">
                <div ng-repeat="comment in comments.data" class="media shadow-z-1 courses-comments">
                    <div class="media-left media-top">
                        <profile-picture nickname="@{{ comment.user.nickname }}" size="profile-picture-medium"></profile-picture>
                    </div>

                    <div class="media-body">
                        <courses-comments-body comment="comment" vote="vote"></courses-comments-body>

                        <div ng-if="comment.comments.length">
                            <hr>

                            <small ng-hide="comment.showSubComments" ng-click="comment.showSubComments = true" class="text-primary cursor-pointer">檢視回覆</small>
                        </div>

                        <div ng-if="comment.showSubComments" class="courses-comments-comments overflow-scroll">
                            <div ng-repeat="subComment in comment.comments" class="media">
                                <div class="media-left">
                                    <profile-picture nickname="@{{ subComment.user.nickname }}" size="profile-picture-small"></profile-picture>
                                </div>

                                <div class="media-body">
                                    <courses-comments-body comment="subComment" vote="vote" is-sub-comment="true"></courses-comments-body>
                                </div>
                            </div>
                        </div>

                        <div ng-if="$root.user.signIn && comment.reply" class="media">
                            <div class="media-left">
                                <profile-picture nickname="@{{ $root.user.nickname }}" size="profile-picture-small"></profile-picture>
                            </div>
                            <div class="media-body">
                                <form ng-submit="commentsComment[comment.id].content.length >= 10 && commentFormSubmit(comment.id)" method="POST" data-toggle="validator">
                                    <fieldset>
                                        <div class="form-group form-group-no-margin">
                                            <label class="sr-only">回覆</label>
                                            <textarea ng-model="commentsComment[comment.id].content" class="form-control textarea-no-resize" rows="1" placeholder="回覆..." data-minlength="10" data-minlength-error="至少需10個字" maxlength="1000" required></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>

                                        <div class="form-group form-group-no-margin text-right">
                                            <label>{!! Form::checkbox('anonymous', true, null, ['ng-model' => 'commentsComment[comment.id].anonymous']) !!} <span>匿名</span></label>

                                            {!! Form::submit('送出', ['class' => 'btn btn-xs btn-success']) !!}
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <ul class="pager">
                        <li ng-class="(comments.prev_page_url) ? '' : 'disabled'" class="previous cursor-pointer"><span ng-click="commentsPaginate(false, comments.prev_page_url)" class="text-primary text-noselect">← 上一頁</span></li>
                        <li ng-class="(comments.next_page_url) ? '' : 'disabled'" class="next cursor-pointer"><span ng-click="commentsPaginate(true, comments.next_page_url)" class="text-primary text-noselect">下一頁 →</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Course exams -->
<div ng-controller="CoursesExamsController">
    <h3><span class="fa fa-file-pdf-o" aria-hidden="true"></span> 考古題</h3><br>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 text-center">
            <table class="table table-striped table-bordered table-hover shadow-z-1">
                <thead>
                    <tr class="info">
                        <th>學期</th>
                        <th>檔名<span ng-if=" ! $root.user.signIn"> (需登入方可下載)</span></th>
                        <th class="hidden-xs">大小</th>
                        <th>下載次數</th>
                        <th class="hidden-xs">上傳時間</th>
                        <th>掃毒結果</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-hide="exams.length">
                        <td colspan="5">尚無檔案</td>
                    </tr>
                    <tr ng-repeat="exam in exams">
                        <td>@{{ exam.semester.name }}</td>
                        <td><a ng-href="/api/courses/exams/@{{ exam.id }}" target="_blank">@{{ exam.file_name }}</a></td>
                        <td class="hidden-xs">@{{ exam.file_size | bytes }}</td>
                        <td>@{{ exam.downloads }}</td>
                        <td class="hidden-xs"><span data-toggle="tooltip" data-placement="bottom" title="@{{ exam.uploaded_at.date }}">@{{ exam.uploaded_at.human }}</span></td>
                        <td>
                            <span ng-if=" ! exam.virustotal_report.length">掃描中</span>
                            <a ng-if="exam.virustotal_report.length" href="@{{ exam.virustotal_report }}" target="_blank"><span class="fa fa-search text-success"></span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">檔案上傳<span ng-hide="$root.user.signIn"> (需登入)</span></div>
                <div class="panel-body">
                    <div>
                        <blockquote>
                            <ul class="ul-noindent">
                                <li>目前支援格式：pdf / jpeg / png / bmp</li>
                                <li>檔案大小限制：4MB</li>
                                <li>尊重智慧財產權，勿上傳非相關檔案或未授權檔案，謝謝</li>
                            </ul>
                        </blockquote>
                    </div>
                    <div ng-if="$root.user.signIn">
                        <form ng-submit="examForm.$valid && examFormSubmit()" name="examForm" method="POST" enctype="multipart/form-data" class="form-inline">
                            <fieldset>
                                <div class="form-group">
                                    <label class="sr-only">學期</label>
                                    <select ng-model="exam.semester" ng-options="semester.name for semester in semesters track by semester.id" class="form-control" required>
                                        <option value="">學期</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="sr-only">檔案</label>
                                    <input ng-model="exam.file" ngf-select ngf-max-size="4MB" type="file" accept="image/jpeg,image/bmp,image/png,application/pdf" required>
                                </div>

                                <div class="form-group">
                                    {!! Form::button('上傳', ['ng-disabled' => '!examForm.$valid', 'type' => 'submit', 'class' => 'btn btn-sm btn-success']) !!}
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>