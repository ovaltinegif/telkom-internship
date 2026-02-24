@props(['status'])

@php
    $status = strtolower($status ?? '');
    
    $classes = match($status) {
        'active' => 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
        'pending' => 'bg-amber-100 dark:bg-amber-500/10 text-amber-800 dark:text-amber-400 border-amber-200 dark:border-amber-500/20',
        'onboarding' => 'bg-blue-100 dark:bg-blue-500/10 text-blue-800 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
        'finished' => 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700',
        'rejected' => 'bg-red-100 dark:bg-red-500/10 text-red-800 dark:text-red-400 border-red-200 dark:border-red-500/20',
        'extension' => 'bg-purple-100 dark:bg-purple-500/10 text-purple-800 dark:text-purple-400 border-purple-200 dark:border-purple-500/20',
        default => 'bg-gray-100 dark:bg-slate-800 text-gray-800 dark:text-slate-400 border-gray-200 dark:border-slate-700',
    };

    $label = match($status) {
        'active' => 'Active',
        'pending' => 'Pending',
        'onboarding' => 'Onboarding',
        'finished' => 'Finished',
        'rejected' => 'Rejected',
        'extension' => 'Extension',
        default => ucfirst($status),
    };

    $icon = match($status) {
        'active' => '<svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/></svg>',
        'pending' => '<svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
        'onboarding' => '<svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>',
        'finished' => '<svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
        'rejected' => '<svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>',
        default => ''
    };
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ' . $classes]) }}>
    {!! $icon !!}
    {{ $label }}
</span>
