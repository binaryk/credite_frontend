<div class="blog-sidebar">
    <!-- CATEGORIES START -->
    <h2 class="no-top-space">Quick booking Here</h2>
    <ul class="nav sidebar-categories margin-bottom-40">
      <li><h4>Pick-up Point :</h4></li>
      <li>
      <select class="select_me" ng-model="point_type" ng-options="point.name for point in point_types track by point_types.id"></select>
      </li>
      <li><a href="#">London </a></li>
      <li><a href="#">Moscow</a></li>
      <li class="active"><a href="#">Paris </a></li>
      <li><a href="#">Berlin</a></li>
      <li><a href="#">Istanbul</a></li>
    </ul>
    <!-- CATEGORIES END -->
    <!-- END BLOG TAGS -->
  </div>