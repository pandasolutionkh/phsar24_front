<div class="card">
	<div class="card-header bg-primary">
        <div class="d-inline-block">
            <h4 class="text-white">{{ __('Sub Categories') }}</h4>
        </div>
    </div>
    <div class="card-body account-profile">
        <div class="menu">
            @foreach($sub_categories as $entity)
            <a href="{{ route('categories.sub',['category_slug'=>$category_slug,'sub_category_slug'=>$entity->slug]) }}">
                {{ $entity->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>