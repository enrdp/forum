<div class="like-dislike-container">

    <button wire:click="like({{$thread->id}})">
        <span class={{ $like->like ?? '' == 1 ? "like" : "notSelected" }}>
            <i style="-webkit-text-stroke-width: 1px; font-size: 30px;" class="bi bi-hand-thumbs-up-fill"></i>
            <div>{{ $countLike }}</div>
        </span>
    </button>

    <button wire:click="dislike({{$thread->id}})">
        <span class={{ $like->dislike ?? '' == 1 ?? '' ? "dislike" : "notSelected" }}>
            <i style="-webkit-text-stroke-width: 1px; font-size: 30px;" class="bi bi-hand-thumbs-down-fill"></i>
            <div>{{ $countDislike }}</div>
        </span>
    </button>


</div>
