<div class="card">
	<div class="card-header bg-primary">
        <div class="d-inline-block">
            <h4 class="text-white">{{ __('Sub Categories') }}</h4>
        </div>
    </div>
    <div class="card-body account-profile">
        <div class="menu">
            @foreach($sub_categories as $entity)
            <a href="{{ route('categories.sub',['id'=>$entity->category_id,'sid'=>$entity->id]) }}">
                {{ $entity->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>