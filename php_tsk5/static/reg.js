document.getElementById('selectformbutton').addEventListener('click', function() {
    document.querySelector('.login-form').style.display = (document.querySelector('.login-form').style.display === 'none') ? 'block' : 'none';
    document.querySelector('.registration-form').style.display = (document.querySelector('.registration-form').style.display === 'none') ? 'block' : 'none';
  });