<!-- BEGIN NAVIGATION -->
<div class="header-navigation pull-right font-transform-inherit">
  <ul>
    <li><a href="{{ route('home')}}">Date generale</a></li>
    @if(auth()->user())
      <li><a href="{!! route('client.solicitari.index') !!}">Solicitările mele</a></li>
      <li><a href="{!! route('comments') !!}" >Comentarii</a></li>
    @endif
    <li><a href="{!! route('terms_conditions') !!}" >Termeni și condiții</a></li>
    <li><a href="{{ route('about') }}">Despre noi</a></li>
  </ul>
</div>
<!-- END NAVIGATION -->

                   