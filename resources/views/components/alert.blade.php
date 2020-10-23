
 @if (session('info'))
    <div class="uk-width-1-1@s uk-alert uk-alert-primary zone-info" 
		onload="" role="alert" uk-alert>
		<a class="uk-alert-close" uk-close></a>
		<span uk-icon="icon:info"></span>
        {{ session('info') }}
    </div>
@endif