<!-- template for the modal component -->
<script type="x/template" id="detail-modal-template">
    <transition name="modal">
        <div class="modal-mask" v-show="show">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-text="modal.title"></h5>
                        <button @click="closeModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-html="modal.body">
                    </div>
                    <div class="modal-footer">
                        <button @click="closeModal()" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</script>