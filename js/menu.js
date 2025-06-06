function showContent(sectionId, button) {
    var sections = document.querySelectorAll('.content-section');
    sections.forEach(function(section) {
        section.classList.remove('active');
    });

    var activeSection = document.getElementById(sectionId);
    if (activeSection) {
        activeSection.classList.add('active');
    }
    var buttons=document.querySelectorAll('.menu button');
    buttons.forEach(function(btn){
        btn.classList.remove('active-button');
    });
    button.classList.add('active-button');
}