<div class="card">
  @isset($header)
    <div class="card-header">{{ $header }}</div>
  @endisset
  <div class="card-body">
    @isset($title)
      <h5 class="card-title">{{ $title }}</h5>
    @endisset
    @isset($text)
      <p class="card-text">{{ $text }}</p>
    @endisset
    {{ $slot }}
  </div>
</div>