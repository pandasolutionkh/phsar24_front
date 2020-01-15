{{-- @section('confirm') --}}
  <!-- Modal Dialog -->
  <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Delete Parmanently</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure about this ?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Cancel</button>
          <button type="button" class="btn btn-danger btn-sm" id="confirm"><i class="fa fa-check"></i> YES</button>
        </div>
      </div>
    </div>
  </div>

{{-- @stop --}}