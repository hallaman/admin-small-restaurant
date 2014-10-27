function changeImage(image, state)
{
   if (state == 'over')
   {
      image.style.backgroundImage = 'url(images/' + image.id + '-hover.png)';
      document.getElementById('plate').style.backgroundImage = 'url(images/' + image.id + '-sunflower-center.png)';
   }
   else
   {
      image.style.backgroundImage = 'url(images/' + image.id + '.png)';
      document.getElementById('plate').style.backgroundImage = 'none';
   }
}
