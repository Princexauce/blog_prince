@php
    $isReply = $depth > 0;
    $avatarSize = $isReply ? 'w-8 h-8 text-sm' : 'w-10 h-10';
    $avatarBg = $isReply ? 'bg-purple-400' : 'bg-purple-600';
    $replies = $comment->replies ?? collect();
    $visibleCount = 2;
    $hiddenCount = max(0, $replies->count() - $visibleCount);
@endphp

<div class="{{ $isReply ? 'border-l-2 border-purple-200 pl-4' : '' }}">
    <div class="flex items-start mb-2">
        <div class="{{ $avatarSize }} rounded-full {{ $avatarBg }} flex items-center justify-center text-white font-bold mr-3 shrink-0">
            {{ strtoupper(substr($comment->pseudo, 0, 2)) }}
        </div>
        <div>
            <p class="font-semibold text-gray-800 {{ $isReply ? 'text-sm' : '' }}">{{ $comment->pseudo }}</p>
            <p class="text-gray-500 {{ $isReply ? 'text-xs' : 'text-sm' }}">{{ \Carbon\Carbon::parse($comment->created_at)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</p>
        </div>
    </div>

    <p class="text-gray-700 {{ $isReply ? 'text-sm' : '' }} mb-2">{{ $comment->contenu }}</p>

    <button type="button" onclick="handleReplyClick({{ $comment->id }}, @json($comment->pseudo))" class="text-purple-600 text-sm hover:text-purple-800 font-medium">
        ↩ Répondre
    </button>

    @if($replies->count() > 0)
        <div class="mt-4 space-y-4 {{ $isReply ? 'ml-2' : 'ml-8 sm:ml-12' }}">
            @foreach($replies->take($visibleCount) as $reply)
                @include('posts.partials.comment-item', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach

            @if($hiddenCount > 0)
                <div id="replies-extra-{{ $comment->id }}" class="hidden space-y-4">
                    @foreach($replies->slice($visibleCount) as $reply)
                        @include('posts.partials.comment-item', ['comment' => $reply, 'depth' => $depth + 1])
                    @endforeach
                </div>
                <button
                    type="button"
                    id="replies-toggle-{{ $comment->id }}"
                    onclick="toggleReplies({{ $comment->id }}, {{ $hiddenCount }})"
                    class="text-purple-600 text-sm font-medium hover:text-purple-800 transition"
                >
                    Afficher {{ $hiddenCount }} autre{{ $hiddenCount > 1 ? 's' : '' }} réponse{{ $hiddenCount > 1 ? 's' : '' }}
                </button>
            @endif
        </div>
    @endif
</div>
