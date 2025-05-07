<div class="contact-container">
    <h1>Kapcsolat</h1>
    
    <?php if (isset($_SESSION['contact_success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['contact_success'] ?>
            <?php unset($_SESSION['contact_success']) ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['contact_error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['contact_error'] ?>
            <?php unset($_SESSION['contact_error']) ?>
        </div>
    <?php endif; ?>
    
    <form id="contact-form" method="post" action="index.php?page=contact_process">
        <div class="form-group">
            <label for="name">Név:</label>
            <input type="text" id="name" name="name" class="form-control" value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['username']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['email']) : '' ?>">
        </div>
        
        <div class="form-group">
            <label for="subject">Tárgy:</label>
            <input type="text" id="subject" name="subject" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="message">Üzenet:</label>
            <textarea id="message" name="message" class="form-control" rows="5"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Küldés</button>
    </form>
</div>

<!-- JavaScript validáció -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const constraints = {
        name: {
            presence: { allowEmpty: false, message: "^A név megadása kötelező" }
        },
        email: {
            presence: { allowEmpty: false, message: "^Az email megadása kötelező" },
            email: { message: "^Érvénytelen email formátum" }
        },
        subject: {
            presence: { allowEmpty: false, message: "^A tárgy megadása kötelező" }
        },
        message: {
            presence: { allowEmpty: false, message: "^Az üzenet megadása kötelező" },
            length: { minimum: 10, message: "^Az üzenet túl rövid (min. 10 karakter)" }
        }
    };

    const form = document.getElementById('contact-form');
    
    form.addEventListener('submit', function(event) {
        const formValues = {
            name: form.elements.name.value,
            email: form.elements.email.value,
            subject: form.elements.subject.value,
            message: form.elements.message.value
        };
        
        const errors = validate(formValues, constraints);
        
        if (errors) {
            event.preventDefault();
            const errorMessages = Object.values(errors)
                .map(function(fieldErrors) { return fieldErrors.join(', '); })
                .join("\n");
            
            alert(errorMessages);
        }
    });
});
</script>
