<div class="modal fade" id="deleteQuestionModal" tabindex="-1" aria-labelledby="deleteQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteQuestionModalLabel">Supprimer la question</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette question? Cette action est irréversible.</p>
                <p class="fw-bold">Titre: <span id="questionTitleToDelete"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteQuestionForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Lorsqu'on clique sur le bouton de suppression
    $('.delete-question-btn').click(function() {
        const questionId = $(this).data('id');
        const questionTitle = $(this).data('title');
        
        // Mettre à jour le modal avec les données de la question
        $('#questionTitleToDelete').text(questionTitle);
        $('#deleteQuestionForm').attr('action', `/monitor/questions/${questionId}`);
        
        // Afficher le modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteQuestionModal'));
        deleteModal.show();
    });
    
    // Soumission du formulaire de suppression
    $('#deleteQuestionForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    // Recharger la page ou mettre à jour le tableau
                    window.location.reload();
                }
            },
            error: function(xhr) {
                alert('Une erreur est survenue lors de la suppression.');
            }
        });
    });
});
</script>