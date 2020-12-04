<li class="site-menu-item ">

    <a target="_blank" class="animsition-link" href="{{ route('app.get',['course-training']) }}?id={{ Auth::user()->id }}">
        <span class="site-menu-title">Access E - Learning</span>
    </a>
</li>


<li class="site-menu-item ">

    <a target="_blank" class="animsition-link" href="{{ route('app.get',['get-offline-training']) }}?id={{ Auth::user()->id }}">
        <span class="site-menu-title">Access Offline Training</span>
    </a>
</li>


@usercan(access_elearning_courses)
    <li class="site-menu-item ">
        <a onclick="showCourses()" type="button" data-toggle="modal" data-target="#course-modal" class="animsition-link">
            <span class="site-menu-title">View Courses</span>
        </a>
    </li>
@endusercan

