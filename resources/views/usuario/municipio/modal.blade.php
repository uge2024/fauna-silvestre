<div class="modal fade" id="modal-delete-{{ $municipio->id_municipio }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $municipio->id_municipio }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('municipio.destroy', $municipio->id_municipio) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel{{ $municipio->id_municipio }}">Eliminar Municipio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que quieres eliminar el municipio "{{ $municipio->nombre }}"?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-light">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>
