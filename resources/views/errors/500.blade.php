<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Something went wrong</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- Optional: remove if your host apps don't use Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
  <div class="max-w-3xl mx-auto my-14 p-8 rounded-2xl border bg-white shadow-sm">
    <h1 class="text-2xl font-semibold mb-1">We hit a snag</h1>
    <p class="text-gray-600">We couldn’t finish that action right now. Your data is safe, and our team has been notified.</p>

    @if($entityRef || $owner)
      <div class="mt-6 p-4 rounded-xl bg-gray-50 border">
        <h2 class="font-medium mb-2">Context</h2>
        <ul class="list-disc pl-6 text-gray-700">
          @if($entityRef)<li>Item: <strong>{{ $entityRef }}</strong></li>@endif
          @if($owner)<li>Submitted/Owned by: <strong>{{ $owner }}</strong></li>@endif
        </ul>
      </div>
    @endif

    <div class="mt-6 p-4 rounded-xl bg-gray-50 border">
      <h2 class="font-medium mb-2">What you can do</h2>
      <ol class="list-decimal pl-6 space-y-2 text-gray-700">
        <li>Try again in a moment.</li>
        <li>
          If it keeps happening, contact <strong>Support</strong>
          @if(($support['email'] ?? null))
            at <a class="underline" href="mailto:{{ $support['email'] }}">{{ $support['email'] }}</a>
          @endif
          @if(($support['phone'] ?? null))
            or call <a class="underline" href="tel:{{ $support['phone'] }}">{{ $support['phone'] }}</a>
          @endif
          @if(($support['whatsapp'] ?? null))
            or <a class="underline" href="https://wa.me/{{ $support['whatsapp'] }}" target="_blank" rel="noopener">WhatsApp us</a>
          @endif
          @if(($support['hours'] ?? null))
            <span class="text-gray-500">({{ $support['hours'] }})</span>
          @endif
          .
        </li>
        <li>Share this incident ID so we can help faster:
          <code class="px-2 py-1 bg-gray-100 rounded">{{ $incidentId ?? '—' }}</code>
        </li>
      </ol>

      @if(($support['docs_url'] ?? null))
        <div class="mt-3">
          <a class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border hover:bg-gray-100"
             href="{{ $support['docs_url'] }}" target="_blank" rel="noopener">View help docs</a>
        </div>
      @endif
    </div>

    <div class="mt-6">
      <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
        Go back and try again
      </a>
      <a href="{{ url('/') }}" class="ml-3 inline-flex items-center px-4 py-2 rounded-lg border hover:bg-gray-100">
        Return to dashboard
      </a>
    </div>

    <p class="mt-8 text-xs text-gray-500">Error code: 500 • Incident: {{ $incidentId ?? '—' }}</p>
  </div>
</body>
</html>
