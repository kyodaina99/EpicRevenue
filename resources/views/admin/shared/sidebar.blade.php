<!-- Navbar Vertical -->
<aside id="navbarSupportedContent" class="sidebar collapse col-lg-2 col-sm-12">
  <div class="navbar-vertical-container">
    <div class="navbar-vertical-footer-offset">

      <!-- Content -->
      <div class="navbar-vertical-content">
        <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">
          <div class="nav-item">
              <a class="nav-link nav-link-main " href="{{ url('/admin') }}" data-placement="left">
                <i class="bi-house-door nav-icon"></i>
                <span class="nav-link-title">{{ __("Dashboard") }}</span>
              </a>
          </div>

          <span class="dropdown-header">{{ __("Management") }}</span>

          <!-- Collapse -->
          <div class="navbar-nav nav-compact">

          </div>
          <div id="navbarVerticalMenuPagesMenu">
            <!-- Collapse -->
            <div class="nav-item">
              <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuPagesUsersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesUsersMenu" aria-expanded="false" aria-controls="navbarVerticalMenuPagesUsersMenu">
                <i class="bi-people nav-icon"></i>
                <span class="nav-link-title">{{ __("Publishers") }} <span class="badge bg-primary rounded-pill ms-1">5</span></span>
              </a>

              <div id="navbarVerticalMenuPagesUsersMenu" class="nav-collapse collapse showwww" data-bs-parent="#navbarVerticalMenuPagesMenu">
                <a class="nav-link " href="/admin/publishers">{{ __("All Publishers") }} <span class="badge bg-primary rounded-pill ms-1">5</span></a>
                <a class="nav-link " href="/admin/publishers/my">{{ __("My Publishers") }}</a>
                <a class="nav-link " href="{{ url('/admin/publishers/pendingW9') }}">{{ __("Pending W9") }}</a>
              </div>
            </div>
            <!-- End Collapse -->

            <div class="nav-item">
              <a class="nav-link nav-link-main" href="{{ url('/admin/payments/') }}" data-placement="left">
                <i class="bi-folder2-open nav-icon"></i>
                <span class="nav-link-title">Payments</span>
              </a>
            </div>

            <div class="nav-item">
              <a class="nav-link nav-link-main" href="{{ url('/admin/payment/methods') }}" data-placement="left">
                <i class="bi-folder2-open nav-icon"></i>
                <span class="nav-link-title">mypayment Method</span>
              </a>
            </div>
            
            <div class="nav-item">
              <a class="nav-link nav-link-main" href="{{ url('/admin/tickets/') }}" data-placement="left">
                <i class="bi-folder2-open nav-icon"></i>
                <span class="nav-link-title">Support Tickets</span>
              </a>
            </div>

            <span class="dropdown-header mt-4">{{ __("Content") }}</span>

            <!-- Collapse -->
            <div class="nav-item">
                <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllPostMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllPostMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllPostMenu">
                  <i class="bi bi-pin-angle-fill nav-icon"></i>
                  <span class="nav-link-title">{{ __("Post") }}</span>
                </a>

                <div id="navbarVerticalMenuAllPostMenu" class="nav-collapse collapse" data-bs-parent="#navbarVerticalMenuPagesMenu">
                  <a class="nav-link " href="{{ route('posts.list') }}">{{ __("All Post") }}</a>
                  <a class="nav-link " href="{{ route('posts.create') }}">{{ __("Create Post") }}</a>
                  <a class="nav-link " href="{{ route('blog.categories.list') }}">{{ __("Categories") }}</a>
                  <a class="nav-link " href="{{ route('blog.tags.list') }}">{{ __("Tags") }}</a>
                  <a class="nav-link " href="{{ route('posts.trash') }}">{{ __("Trash") }}</a>
                </div>
              </div>
              <!-- End Collapse -->

            <!-- Collapse -->
            <div class="nav-item">
              <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllCompaignMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllCompaignMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllCompaignMenu">
                <i class="bi bi-pin-angle-fill nav-icon"></i>
                <span class="nav-link-title">{{ __("Campaigns") }}</span>
              </a>

              <div id="navbarVerticalMenuAllCompaignMenu" class="nav-collapse collapse " data-bs-parent="#navbarVerticalMenuPagesMenu">
                <a class="nav-link " href="{{ url('/admin/#/campaigns/') }}">{{ __("View Campaigns") }}</a>
                <a class="nav-link " href="{{ url('/admin/campaigns/create') }}">{{ __("Create Campaign") }}</a>
                <a class="nav-link activeee" href="{{ url('/admin/campaigns/categories') }}">{{ __("Categories") }}</a>
                <a class="nav-link activeee" href="{{ url('/admin/campaigns/featured') }}">{{ __("Featured") }}</a>
                <a class="nav-link activeee" href="{{ url('/admin/campaigns/rates') }}">{{ __("Custom rates") }}</a>
                <a class="nav-link activeee" href="{{ url('/admin/campaigns/block/?subids') }}">{{ __("SubID's block") }}</a>
                <a class="nav-link activeee" href="{{ url('/admin/campaigns/block/?singleBlock') }}">{{ __("Single block") }}</a>
                <a class="nav-link activeee" href="{{ url('/admin/campaigns/block/?networkBlock') }}">{{ __("Network block") }}</a>
              </div>
            </div>
            <!-- End Collapse -->

            

            <!-- Collapse -->
            <div class="nav-item">
              <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllOrdersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllOrdersMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllOrdersMenu">
                <i class="bi bi-receipt nav-icon"></i>
                <span class="nav-link-title">{{ __("Rewards") }}</span>
              </a>
              <div id="navbarVerticalMenuAllOrdersMenu" class="nav-collapse collapse showwww" data-bs-parent="#navbarVerticalMenuPagesMenu">
                <a class="nav-link activeee" href="{{ url('/admin/rewards') }}">{{ __("View Rewards") }}</a>
                <a class="nav-link " href="{{ url('/admin/rewards/create') }}">{{ __("Add Reward") }}</a>
              </div>
            </div>
            <!-- End Collapse -->

            <!-- Collapse -->
            <div class="nav-item">
              <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllContestMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllContestMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllContestMenu">
                <i class="bi bi-receipt nav-icon"></i>
                <span class="nav-link-title">{{ __("Contest") }}</span>
              </a>
              <div id="navbarVerticalMenuAllContestMenu" class="nav-collapse collapse showwww" data-bs-parent="#navbarVerticalMenuPagesMenu">
                <a class="nav-link activeee" href="#/contests/">{{ __("All Contest") }}</a>
                <a class="nav-link " href="{{ url('/admin/rewards/create') }}">{{ __("Create Contest") }}</a>
              </div>
            </div>
            <!-- End Collapse -->

            <span class="dropdown-header mt-4">{{ __("General") }}</span>

            <div class="nav-item">
              <a class="nav-link nav-link-main" href="{{ url('/admin/#/reports/') }}" data-placement="left">
                <i class="bi-folder2-open nav-icon"></i>
                <span class="nav-link-title">Reports</span>
              </a>
            </div>

            <!-- Collapse -->
            <div class="nav-item">
              <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllPostbackMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllPostbackMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllPostbackMenu">
                <i class="bi bi-receipt nav-icon"></i>
                <span class="nav-link-title">{{ __("Postbacks") }}</span>
              </a>
              <div id="navbarVerticalMenuAllPostbackMenu" class="nav-collapse collapse showwww" data-bs-parent="#navbarVerticalMenuPagesMenu">
                <a class="nav-link activeee" href="{{ url('/admin/postbacks/') }}">{{ __("All Postbacks") }}</a>
                <a class="nav-link " href="{{ url('/admin/tools/postbackTest') }}">{{ __("Postbacks Test") }}</a>
              </div>
            </div>
            <!-- End Collapse -->

            <!-- Collapse -->
            <div class="nav-item">
              <a class="nav-link nav-link-main dropdown-toggle " href="#navbarVerticalMenuAllLogsMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuAllLogsMenu" aria-expanded="false" aria-controls="navbarVerticalMenuAllLogssMenu">
                <i class="bi bi-receipt nav-icon"></i>
                <span class="nav-link-title">{{ __("Logs") }}</span>
              </a>
              <div id="navbarVerticalMenuAllLogsMenu" class="nav-collapse collapse showwww" data-bs-parent="#navbarVerticalMenuPagesMenu">
                <a class="nav-link activeee" href="{{ url('/admin/tools/postbackTest') }}">{{ __("Postback Logs") }}</a>
                <a class="nav-link " href="{{ url('/admin/publishers/failedLogins') }}">{{ __("Failed Logins") }}</a>
              </div>
            </div>
            <!-- End Collapse -->

            <div class="nav-item">
              <a class="nav-link nav-link-main " href="#" data-placement="left">
                <i class="bi-key nav-icon"></i>
                <span class="nav-link-title">keys</span>
              </a>
            </div>
            
            @if(auth()->user()->role == 1)
            <div class="nav-item">
              <a class="nav-link nav-link-main " href="{{ url('/logout') }}" data-placement="left">
                <i class="bi-key nav-icon"></i>
                <span class="nav-link-title">Logout</span>
              </a>
            </div>
            @endif

      </div>
      <!-- End Content -->

      <!-- Footer -->
      <div class="navbar-vertical-footer">
        <ul class="navbar-vertical-footer-list">
          

          
        </ul>
      </div>
      <!-- End Footer -->
    </div>
  </div>
</aside>
<!-- End Navbar Vertical -->
