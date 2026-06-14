@php
    $variant = $variant ?? 'dropdown';
@endphp

@if($variant === 'dropdown')
    <div class="flex items-center mb-3">
        <div class="w-14 h-14 bg-purple-600 rounded-full flex items-center justify-center text-white text-lg font-bold mr-4 shrink-0">AP</div>
        <div>
            <h4 class="font-bold text-gray-800">ADIMI Prince</h4>
            <p class="text-purple-600 text-sm font-medium">Génie informatique & télécommunication</p>
        </div>
    </div>
    <p class="text-gray-600 text-sm leading-relaxed mb-3">
        Étudiant en 3<sup>e</sup> année à l'EPAC (École Polytechnique d'Abomey-Calavi), Université d'Abomey-Calavi — Bénin.
    </p>
    <p class="text-gray-500 text-xs leading-relaxed">
        BlogPrince est mon espace pour partager des articles sur la tech, la vie étudiante et mes apprentissages du développement web.
    </p>
@else
    <div class="text-center">
        <div class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">AP</div>
        <h4 class="font-bold text-gray-800 text-lg">ADIMI Prince</h4>
        <p class="text-purple-600 text-sm font-medium mb-4">Étudiant à l'EPAC — UAC, Bénin</p>
    </div>
    <div class="space-y-3 text-sm text-gray-600 leading-relaxed">
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Formation</p>
            <p>3<sup>e</sup> année en génie informatique et télécommunication à l'EPAC (École Polytechnique d'Abomey-Calavi).</p>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Ce blog</p>
            <p>BlogPrince est mon espace personnel pour publier des réflexions, documenter mes projets et partager ce que j'apprends autour du développement web et de l'informatique.</p>
        </div>
    </div>
@endif
