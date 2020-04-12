<?php include 'php/layout/navbar.php';?>
<head><title>Cuppee | Contact Us</title></head>
    <form class="contact__form form" method="post" action="php/mail.php">
        <h1 class="primary-header form__header">Contact form</h1>
        <p class="form__paragraph">
            Want to buy a cup? Questions? Feedback? Interested in our wholesale rates? Contact us today. We aim to respond within 24 hours.
        </p>

        <div class="alert alert-success contact__msg" style="display: none" role="alert">
            Your message was sent successfully.
        </div>

        <div class="form__group">
            <input type="text" class="form__input" placeholder="Full Name" name="name" required>
            <label for="name" class="form__label">Full name</label>
        </div>

        <div class="form__group">
            <input type="email" class="form__input" placeholder="Email address" name="email" required>
            <label for="email" class="form__label">Email address</label>
        </div>

        <div class="form__group">
            <textarea rows="6" class="form__input" name="message"
            placeholder="Please leave your message here..." type="text" required></textarea>
            <label for="message" class="form__label form__label--message">Message</label>
        </div>
        
        <div class="form__group">
            <input id="form__submission" class="btn-contact form__submition" name="submit" type="submit" value="Send &rarr;" onclick="clearField();">
        </div>
    </form>
    <script src="js/contact-form.js"></script> 
<?php include 'php/layout/footer.php';?>