# Toilet-time
Jacobs hack 2015 submission using an Estimote with a Seller microcontroller to map toilet usage.

##Description
The gist of the idea is a system so that you never have to queue for the toilet again. We approximate toilet usage with bluetooth signal strenght. 

Using an estimote node to connect with tessel micro-controller to gather the signal data, and then we process it on the back-end interface which is then presented on a map to find your nearst available toilet. We ran accross multiple technical diffuclties on the hardware side. Initially the tessel micro-controller API didn't work. And later, we ran accross trouble unlocking the estimote node due to the fact that the estimote server's been down. So this is the reason we couldn't utilize the full functionnalites of the estimote and therefor a signal processing method was adopted. We used normal distribution models to classify whether the node is moving or not approximating the two classes with two gaussians comparing their standard deviations. So when the toilet door is opened the signal is gonna fluctuate. This is in turn going to flatten out that gaussian while the other gaussian will just stay quite narrow. You can also purchase toilet rolls on our site from our sponsor company toilet inc. using the braintree API.
