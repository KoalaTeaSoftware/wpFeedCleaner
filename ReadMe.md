# WordPress Feed Cleaner
Getting XML out of WordPress is fairly trivial, but the XML that you see is really rather muddy. This 
1. Cuts out a lot of the stuff that you probably will never want to have to deal with.
1. Replaces WP classes applied to imgs and embeds with ones that play nicely with Bootstrap (4, but that is not essential).

See https://koalatea-software.com/development/wordpress/xml-feeds-from-your-wordpress-site/ for a bit of info about this.

The coding style aims for simplicity (particularly of the regexps) instead of efficiency, but it is adequately fast. 


## Usage
* Just put the file in an appropriate place in the project
* It does require an error handler, but that is a minor bind
    * Conceivably the file that is here may lose the plot with the location of the error log file.

## Testing
See the two files called test... you can simple GET one and see that the stuff it produces look nice.
