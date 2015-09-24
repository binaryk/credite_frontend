<?php
/*Chat*/
    Route::get('messages',['as' => 'messages.index', 'uses' => 'MessagesController@index']);
    Route::get('messages/compose',['as' => 'messages.compose', 'uses' => 'MessagesController@compose']);


    Route::get('/chat/index',['as' => 'chat.index', 'uses' => 'ChatController@index']);
    Route::post('/chat/indexchat/',['as' => 'chat.index.chat', 'uses' => 'ChatController@indexChat']);
    Route::post('/chat/indexchat/send',['as' => 'chat.index.send', 'uses' => 'ChatController@store']);
    Route::get('/chat/indexchat/checkmessages',['as' => 'chat.index.checkmessages', 'uses' => 'ChatController@checkMessages']);

 include(app_path() . '/~Libs/routes/commons.php');
        
Route::group(['middleware' => 'switcher'], function () {

    Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
    Route::get('/profile', ['as' => 'profile', 'uses' => 'DashboardController@profile']);
    Route::post('/profile', ['uses' => 'DashboardController@profile']);
    Route::post('/upload', ['as' => 'image.upload', 'uses' => 'ImageController@upload']);

    # Super administrator role
    Route::group(['middleware' => 'role', 'role' => ['superadmin', 'admin']], function () {

        Route::get('/import', ['as' => 'import', 'uses' => 'ImportController@index']);
        Route::post('/import', ['uses' => 'ImportController@import']);

    });

    # Administrator role
    Route::group(['middleware' => 'role', 'role' => 'admin'], function () {

        include(app_path() . '/~Libs/routes/admins.php');
        include(app_path() . '/~Libs/routes/administration/students.php');
        include(app_path() . '/~Libs/routes/administration/groups.php');
        include(app_path() . '/~Libs/routes/administration/teachers.php');

        Route::get('/institution', ['as' => 'institution', 'uses' => 'InstitutionController@edit']);
        Route::post('/institution', ['uses' => 'InstitutionController@editPost']);

        ### Admins

        Route::get('/admins', ['as' => 'admins', 'uses' => 'AdministratorsController@index']);
        Route::get('/admins/add', ['as' => 'admins.add', 'uses' => 'AdministratorsController@add']);
        Route::post('/admins/add', ['uses' => 'AdministratorsController@addPost']);
        Route::get('/admins/edit/{admin}', ['as' => 'admins.edit', 'uses' => 'AdministratorsController@edit']);
        Route::post('/admins/edit/{admin}', ['uses' => 'AdministratorsController@editPost']);
        Route::get('/admins/remove/{admin}', ['as' => 'admins.remove', 'uses' => 'AdministratorsController@remove']);

        ### Teachers
        Route::get('/teachers', ['as' => 'teachers', 'uses' => 'TeachersController@index']);
        Route::get('/teachers/add', ['as' => 'teachers.add', 'uses' => 'TeachersController@add']);
        Route::post('/teachers/add', ['uses' => 'TeachersController@addPost']);
        Route::get('/teachers/edit/{teacher}', ['as' => 'teachers.edit', 'uses' => 'TeachersController@edit']);
        Route::post('/teachers/edit/{teacher}', ['uses' => 'TeachersController@editPost']);
        Route::get('/teachers/remove/{teacher}', ['as' => 'teachers.remove', 'uses' => 'TeachersController@remove']);

        ### Groups

        Route::get('/groups', ['as' => 'groups', 'uses' => 'GroupsController@index']);
        Route::get('/groups/add', ['as' => 'groups.add', 'uses' => 'GroupsController@add']);
        Route::post('/groups/add', ['uses' => 'GroupsController@addPost']);
        Route::get('/groups/edit/{group}', ['as' => 'groups.edit', 'uses' => 'GroupsController@edit']);
        Route::post('/groups/edit/{group}', ['uses' => 'GroupsController@editPost']);
        Route::get('/groups/remove/{group}', ['as' => 'groups.remove', 'uses' => 'GroupsController@remove']);

        # Students & subjects

        Route::get('/groups/{group}/students', ['as' => 'groups.students', 'uses' => 'GroupsController@students']);
        Route::get('/groups/{group}/students/add', ['as' => 'groups.students.add', 'uses' => 'GroupsController@studentsAdd']);
        Route::post('/groups/{group}/students/add', ['uses' => 'GroupsController@studentsAddPost']);
        Route::get('/groups/{group}/student/{student}/remove', ['as' => 'groups.student.remove', 'uses' => 'GroupsController@studentRemove']);

        Route::get('/groups/{group}/subjects', ['as' => 'groups.subjects', 'uses' => 'GroupsController@subjects']);
        Route::get('/groups/{group}/subjects/add', ['as' => 'groups.subjects.add', 'uses' => 'GroupsController@subjectsAdd']);
        Route::post('/groups/{group}/subjects/add', ['uses' => 'GroupsController@subjectsAddPost']);
        Route::get('/groups/{group}/subject/{pivot}/remove', ['as' => 'groups.subject.remove', 'uses' => 'GroupsController@subjectRemove'])
             ->where(['pivot' => '[0-9]+']);

        ### Students

        Route::get('/students', ['as' => 'students', 'uses' => 'StudentsController@index']);
        Route::get('/students/add', ['as' => 'students.add', 'uses' => 'StudentsController@add']);
        Route::post('/students/add', ['uses' => 'StudentsController@addPost']);
        Route::get('/students/edit/{student}', ['as' => 'students.edit', 'uses' => 'StudentsController@edit']);
        Route::post('/students/edit/{student}', ['uses' => 'StudentsController@editPost']);
        Route::get('/students/remove/{student}', ['as' => 'students.remove', 'uses' => 'StudentsController@remove']);
        Route::get('/students/{student}/custodians', ['as' => 'students.custodians', 'uses' => 'StudentsController@custodians']);
        Route::get('/students/{student}/custodians/add', ['as' => 'students.custodians.add', 'uses' => 'StudentsController@custodiansAdd']);
        Route::post('/students/{student}/custodians/add', ['uses' => 'StudentsController@custodiansAddPost']);
        Route::get('/students/{student}/custodians/find', ['as' => 'students.custodians.find', 'uses' => 'StudentsController@custodiansFind']);
        Route::post('/students/{student}/custodians/find', ['uses' => 'StudentsController@custodiansFindPost']);
        Route::get('/students/{student}/custodians/{custodian}/edit', ['as' => 'students.custodians.edit', 'uses' => 'StudentsController@custodiansEdit']);
        Route::post('/students/{student}/custodians/{custodian}/edit', ['uses' => 'StudentsController@custodiansEditPost']);
        Route::get('/students/{student}/custodians/{custodian}', ['as' => 'students.custodians.remove', 'uses' => 'StudentsController@custodiansRemove']);
     
        Route::get('/students/grades/{student}/', ['as' => 'students.grades.index', 'uses' => 'StudentsController@gradesIndex']);

        ### Subjects

        Route::get('/subjects', ['as' => 'subjects', 'uses' => 'SubjectsController@index']);
        Route::get('/subjects/add', ['as' => 'subjects.add', 'uses' => 'SubjectsController@add']);
        Route::post('/subjects/add', ['uses' => 'SubjectsController@addPost']);
        Route::get('/subjects/edit/{subject}', ['as' => 'subjects.edit', 'uses' => 'SubjectsController@edit']);
        Route::post('/subjects/edit/{subject}', ['uses' => 'SubjectsController@editPost']);
        Route::get('/subjects/remove/{subject}', ['as' => 'subjects.remove', 'uses' => 'SubjectsController@remove']);
        Route::get('/subjects/{subject}', ['as' => 'subjects.show', 'uses' => 'SubjectsController@show']);

        # Years and semesters

        Route::get('/years', ['as' => 'years', 'uses' => 'YearsController@index']);
        Route::get('/years/mock/{semester}', ['as' => 'years.mock', 'uses' => 'YearsController@mock']);
        Route::get('/years/{semester}', ['as' => 'years.active', 'uses' => 'YearsController@active']);

        ### Countries / counties

        Route::get('/cities/{county}', ['as' => 'cities', 'uses' => 'GeoController@cities']);
        Route::get('/counties/{country}', ['as' => 'counties', 'uses' => 'GeoController@counties']);

    });

    # Teacher role
    Route::group(['middleware' => 'role', 'role' => 'teacher'], function () {


        include(app_path() . '/~Libs/routes/profesori.php');

        /**
         * Routa ca sa vad clasele unui profesor
         * aici am button "Deschide clasa"
         */  
        Route::get('/my-groups', [
            'as'   => 'teacher.groups', 
            'uses' => 'TeacherGroupsController@index'
        ]);

        /**
         * Routa ca sa vad elevii unei clase
         * aici ajung de la "Deschide clasa"
         * class = id-ul din subject_teacher_group ==> stiu subject_id, group_id, user_id
         */  
        Route::get('/my-groups/{class}', [
            'as' => 'teacher.group', 
            'uses' => 'TeacherGroupsController@show'
        ])->where('class', '[0-9]+');

        Route::get('/my-groups/{class}/grades/{date?}', ['as' => 'teacher.grades', 'uses' => 'TeacherGroupsController@grades'])
             ->where([
                 'class' => '[0-9]+',
                 'date'  => '[0-9]{2}\.[0-9]{2}\.20[0-9]{2}',
             ]);

        Route::post('/my-groups/{class}/grades/{date?}', ['uses' => 'TeacherGroupsController@gradesPost'])
             ->where([
                 'class' => '[0-9]+',
                 'date'  => '[0-9]{2}\.[0-9]{2}\.20[0-9]{2}',
             ]);
    });

    # Parent role

    Route::group(['middleware' => 'role', 'role' => ['custodian', 'student']], function () {

        Route::get('/my-subjects', ['as' => 'parent.subjects', 'uses' => 'ParentViewController@index']);
        Route::get('/my-subjects/{class}', ['as' => 'parent.grades', 'uses' => 'ParentViewController@show'])
             ->where(['class' => '[0-9]+']);

        include(app_path() . '/~Libs/routes/parinti.php');

    });

});

Route::group(['prefix' => 'auth', 'middleware' => 'auth'], function () {

    Route::get('/logout', ['as' => 'auth.logout', 'uses' => 'AuthController@logout']);
    Route::get('/switcher', ['as' => 'auth.switcher', 'uses' => 'AuthController@switcher']);
    Route::post('/switcher', ['uses' => 'AuthController@postSwitcher']);

});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {

    Route::get('/login', ['as' => 'auth.login', 'uses' => 'AuthController@login']);
    Route::post('/login', ['uses' => 'AuthController@postLogin']);

    Route::get('/reset', ['as' => 'auth.getEmail', 'uses' => 'AuthController@getEmail']);
    Route::post('/reset', ['as' => 'auth.postEmail', 'uses' => 'AuthController@postEmail']);

    Route::get('/reset/{token}', ['as' => 'auth.getReset', 'uses' => 'AuthController@getReset'])
         ->where(['token' => '[0-9a-f]+']);

    Route::post('/reset/{token}', ['as' => 'auth.postReset', 'uses' => 'AuthController@postReset']);

});




//Route::get('/demo', ['as' => 'demo', 'uses' => 'DashboardController@demo']);

Route::post('ajax-save-grade',[
    'as' => 'ajax-save-grade',
    'uses' => 'TeacherGroupsController@addGrade',
]);

Route::post('ajax-save-absence',[
    'as' => 'ajax-save-absence',
    'uses' => 'TeacherGroupsController@addAbsence',
]);

Route::post('ajax-send-message',[
    'as' => 'ajax-send-message',
    'uses' => 'TeacherGroupsController@sendMessage',
]);