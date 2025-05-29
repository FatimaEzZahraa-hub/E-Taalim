@props(['activeTab' => 'cours'])

@if(request()->is('enseignant/cours*') || request()->is('enseignant/travaux*') || request()->is('enseignant/examens*') || request()->is('enseignant/soumissions*'))
<div class="course-tabs mb-4">
    <div class="container-fluid px-0">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'cours' ? 'active' : '' }}" href="{{ route('enseignant.cours') }}">
                    <i class="bi bi-book me-1"></i> Cours
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'travaux' ? 'active' : '' }}" href="{{ route('enseignant.travaux') }}">
                    <i class="bi bi-file-earmark-text me-1"></i> Travaux & Devoirs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'examens' ? 'active' : '' }}" href="{{ route('enseignant.examens') }}">
                    <i class="bi bi-clipboard-check me-1"></i> Examens
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'soumissions' ? 'active' : '' }}" href="{{ route('enseignant.soumissions') }}">
                    <i class="bi bi-inbox me-1"></i> Soumissions
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
