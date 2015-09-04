<div class="blog-sidebar">
    <h2 class="no-top-space">Quick booking Here</h2>
    <ul class="nav sidebar-categories margin-bottom-40">
      
      <li><h4>Pick-up Point :</h4></li>
      <li>
        <select class="select_me" ng-change="changePoint()" ng-model="point_type" ng-options="key as value for (key, value) in point_types"></select>
      </li>

     <div class="col-md-12">
       <p>Selected: {[airport.selected]}</p>
         <ui-select on-select="selectAirport($item, $model)" ng-model="airport.selected" theme="select2" ng-disabled="disabled" style="min-width: 300px;" title="Choose a airport">
           <ui-select-match placeholder="Select...">{[$select.selected.name]}</ui-select-match>
           <ui-select-choices repeat="airport in airports | propsFilter: {name: $select.search}">
             <div ng-bind-html="airport.name | highlight: $select.search"></div>
             <small>
               airport: {[airport.name]}
             </small>
           </ui-select-choices>
         </ui-select>
     </div>


      <li>
       <p>Selected: {[point.selected]}</p>



      </li>
      <li>
          <textarea ng-model="adress" class="col-md-12 vertical">
          </textarea> 

      </li> 
    </ul>
    <!-- CATEGORIES END -->
    <!-- END BLOG TAGS -->
  </div>