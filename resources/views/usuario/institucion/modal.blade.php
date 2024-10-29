<div class="modal fade" id="modal-delete-{{ $institucion->id_institucion }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $institucion->id_institucion }}" aria-hidden="true">
    <form action="{{ route('institucion.destroy', $institucion->id_institucion) }}" method="post">
        @csrf
        @method('DELETE')
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel-{{ $institucion->id_institucion }}">Confirmar Eliminación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres eliminar esta institución? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </form>
</div>
