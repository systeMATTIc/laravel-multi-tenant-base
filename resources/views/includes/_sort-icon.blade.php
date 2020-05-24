@if ($sortField !== $field)
  <svg class="fill-current h-2 inline text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
    <path d="M9 3.828L2.929 9.899 1.515 8.485 10 0l.707.707 7.778 7.778-1.414 1.414L11 3.828V20H9V3.828z"/>
  </svg>
  <svg class="fill-current h-2 inline text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
    <path d="M9 16.172l-6.071-6.071-1.414 1.414L10 20l.707-.707 7.778-7.778-1.414-1.414L11 16.172V0H9z"/>
  </svg>
@elseif ($sortAsc)
  <svg class="fill-current h-2 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
    <path d="M9 3.828L2.929 9.899 1.515 8.485 10 0l.707.707 7.778 7.778-1.414 1.414L11 3.828V20H9V3.828z"/>
  </svg>
@else
  <svg class="fill-current h-2 inline" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
    <path d="M9 16.172l-6.071-6.071-1.414 1.414L10 20l.707-.707 7.778-7.778-1.414-1.414L11 16.172V0H9z"/>
  </svg>
@endif