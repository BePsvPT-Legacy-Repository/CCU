<!-- Courses search form -->
<div class="text-center">
    <form class="form-inline">
        <fieldset>
            <div class="form-group">
                <label class="sr-only">系所</label>
                <select ng-model="search.department" ng-change="searchFormSubmit()" ng-options="department.name for department in options.departments track by department.id" class="form-control">
                    <option value="">系所</option>
                </select>
            </div>

            <div ng-show="117 === search.department.id" class="form-group">
                <label class="sr-only">向度</label>
                <select ng-model="search.dimension" ng-change="searchFormSubmit()" ng-options="dimension.name for dimension in options.dimensions track by dimension.id" class="form-control">
                    <option value="">向度</option>
                </select>
            </div>

            <div class="form-group">
                {!! Form::label('keyword', '代碼/課名/教授', ['class' => 'sr-only']) !!}
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-search" aria-hidden="true"></span></span>
                    {!! Form::input('search', 'keyword', null, ['ng-model' => 'search.keyword', 'ng-change' => 'searchFormSubmit()', 'class' => 'form-control floating-label', 'placeholder' => '代碼/課名/教授']) !!}
                </div>
            </div>
        </fieldset>
    </form>
</div>

<!-- Courses search result -->
<div class="row text-center">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1">
        <hr>

        <table class="table table-striped table-bordered table-hover shadow-z-1">
            <thead>
                <tr class="info">
                    <th>系所</th>
                    <th class="hidden-xs">課程代碼</th>
                    <th>課程名稱</th>
                    <th>授課教授</th>
                    <th>評論</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-hide="courses.length">
                    <td colspan="5">嘗試換個系所看看</td>
                </tr>
                <tr ng-repeat="course in courses">
                    <td>@{{ course.department.name }}</td>
                    <td class="hidden-xs">@{{ course.code }}</td>
                    <td><a ui-sref="courses-show({ courseId: course.id })">@{{ course.name }}</a></td>
                    <td>@{{ course.professor }}</td>
                    <td>
                        <span ng-hide="course.comments.length">-</span>
                        <span ng-show="course.comments.length" class="text-primary" data-toggle="tooltip" data-placement="bottom" title="@{{ course.comments.length }} 則">✓<span class="hidden-xs"> 已有評論</span></span>
                    </td>
                </tr>
            </tbody>
        </table>

        <hr>
    </div>
</div>

<!-- Courses comments and exams -->
<div class="row">
    <div class="col-xs-12 col-sm-5 col-sm-offset-1">
        <h3 class="text-center">最新留言</h3>

        <div ng-repeat="comment in comments" class="media shadow-z-1 courses-comments">
            <div class="media-left media-top">
                <profile-picture nickname="@{{ comment.user.nickname }}" size="profile-picture-medium"></profile-picture>
            </div>
            <div class="media-body">
                <a ui-sref="courses-show({ courseId: comment.course.id })" data-toggle="tooltip" data-placement="bottom" title="@{{ comment.course.department.name + ' - ' + comment.course.professor }}" class="pull-right">@{{ comment.course.name }}</a>

                <courses-comments-body comment="comment" disable-action="true"></courses-comments-body>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-xs-offset-0 col-sm-5 col-sm-offset-0 text-center">
        <courses-exams heading="最新考古題" exams="exams.newest"></courses-exams>

        <courses-exams heading="熱門考古題" exams="exams.hottest"></courses-exams>
    </div>
</div>