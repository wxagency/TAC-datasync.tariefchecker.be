<ul class="nav">
    <!--<li class="active ">
      <a href="{{url('/home')}}">
        <i class="fas fa-home"></i>
        <p>Dashboard</p>
      </a>
    </li>-->
    <li>
      <a href="{{route('manualsync.index')}}">
        <i class="fas fa-sync"></i>
        <p>Data Syncing</p>
      </a>
    </li>
    <!-- <li>-->
    <!--  <a href="{{route('backup.index')}}">-->
    <!--    <i class="fas fa-random"></i>-->
    <!--    <p>Backup</p>-->
    <!--  </a>-->
    <!--</li>-->
    <li>
      <a href="{{route('data-restore.index')}}">
        <i class="fas fa-random"></i>
        <p>Data Restore</p>
      </a>
    </li>
    <li>
    <a href="{{route('discount.create')}}">
      <i class="fas fa-file"></i>
      <p>Manage Discount</p>
    </a>
    <!--<ul class="sub-menu">-->
    <!--  <li class="">-->
    <!--    <a href="{{route('discount.index')}}" class="nav-link ">-->
    <!--      <p class="title">All Discount</p>-->
    <!--    </a>-->
    <!--  </li> -->
      <!-- <li class="">
        <a href="#" class="nav-link ">
          <p class="title">View categories</p>
        </a>
      </li> -->
    <!--</ul>-->
  </li>

    <li> 
      <a href="{{route('usersearch.index')}}">
        <i class="fas fa-users"></i>
        <p>User search History</p>
      </a>
    </li>
    <!-- <li>
      <a href="./user.html">
        <i class="fas fa-cog"></i>
        <p>API</p>
      </a>
    </li> -->
    
   
  </ul> 
<script type="text/javascript">
  $(document).ready(function() {
    if (window.location.href.indexOf("home") > -1) {
      window.location.replace("https://datasync.tariefchecker.be/manualsync");
    }
    $(".navbar-brand").text("Airtable to Engine 2.0 Tariefchecker Data Sync and Restore");
  });
</script>