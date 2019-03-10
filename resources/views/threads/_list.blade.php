@forelse ($threads as $thread)
  <div class="card">
    <div class="card-header">
      <div class="level">
        <h4 class="flex">
          <a href="{{ $thread->path() }}">
            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
              <strong>
                {{ $thread->title }}
              </strong>
            @else
              {{ $thread->title }}
            @endif
          </a>
        </h4>

        <a href="{{ $thread->path() }}">
          {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
        </a>
      </div>
    </div>

    <div class="card-body">
      <div class="body">{{ $thread->body }}</div>
    </div>
  </div>
@empty
  <p>There are no relevant results at this time.</p>
@endforelse