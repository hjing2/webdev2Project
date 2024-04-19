<div class="sidebar">
    <ul>
        <li><a href="adoptable_list.php">Adoptable Pets</a></li>
        <!-- <li><a href="pet_forum.php">Pet Forum</a></li> -->
        <li><a href="story_list.php">Adoption Stories</a></li>
        <li><a href="adoption_guideline.php">Adoption Guidelines</a></li>
        <!-- <li><a href="volunteer_application.php">Volunteer Application</a></li> -->
        <?php if ((isset($_SESSION['is_admin'])) && ($_SESSION['is_admin']) == 1): ?>
            <li><a href="admin.php">Admin Panel</a></li>
        <?php endif; ?>
    </ul>
</div>