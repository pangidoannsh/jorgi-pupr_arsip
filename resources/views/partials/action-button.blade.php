<div class="btn-group">
    <a href="{{ route('report.edit', $item) }}" class="btn btn-sm btn-primary">
        <i class="bi bi-pencil"></i>
    </a>
    <form action="{{ route('report.destroy', $item->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 0 .25rem .25rem 0">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
