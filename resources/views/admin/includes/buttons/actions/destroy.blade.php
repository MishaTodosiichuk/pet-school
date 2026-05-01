<form action="{{ route($routes['destroy'], $action['id']) }}" method="post">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Ви впевнені?')">
        <i class="fas fa-trash"></i>
    </button>
</form>
