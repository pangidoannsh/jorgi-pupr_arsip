<div class="btn-group">
    <a href="{{ route('arsip.show', $item) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-eye"></i>
    </a>
    <a href="{{ route('arsip.edit', $item) }}" class="btn btn-sm btn-warning">
        <i class="bi bi-pencil"></i>
    </a>
    <form action="{{ route('arsip.destroy', $item->id) }}" method="POST" class="formDelete">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 0 .25rem .25rem 0">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>