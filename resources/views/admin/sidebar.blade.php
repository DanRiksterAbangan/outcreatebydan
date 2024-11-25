<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('chatify') }}">Chats</a>
            </li>

            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.users') }}">Users</a>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.client-verifications.list') }}">Client Verification</a>
            </li>

            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.jobs.jobs-list') }}">Jobs</a>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.jobs.jobApplications') }}">Job Applications</a>
            </li> 

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.hires.hires-list') }}">Hires</a>
            </li> 

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.freelancer-verifications.list') }}">Freelancer Verification</a>
            </li> 

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.contacts.contacts-list') }}">Contacts</a>
            </li> 

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.logout') }}">Logout</a>
            </li>                                                        
        </ul>
    </div>
</div>