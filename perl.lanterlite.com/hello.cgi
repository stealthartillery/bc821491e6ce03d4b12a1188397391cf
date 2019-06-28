#!C:\xampp\perl\bin\perl.exe
#!/usr/bin/perl
# The above line is perl execution path in xampp
# The below line tells the browser, that this script will send html content.
# If you miss this line then it will show "malformed header from script" error.
print "Content-type: text/html\n\n";

# print "Hello world.";
# print "Hello world.";

use strict;
use warnings;

@ages = (25, 30, 40);             
@names = ("John Paul", "Lisa", "Kumar");

print "\$ages[0] = $ages[0]\n";
print "\$ages[1] = $ages[1]\n";

filenames_read('asd/');
sub filenames_read {
	my ($_dir) = @_;
	# Tiny.pm file must be in 'Path-Tiny\lib\xxx\Tiny.pm';
	use lib 'Path-Tiny\lib';
	use Path::Tiny;
	my $dir = path($_dir); # foo/bar
	# Iterate over the content of foo/bar
	my $iter = $dir->iterator;
	while (my $file = $iter->()) {
	    # See if it is a directory and skip
	    next if $file->is_dir();
	    # Print out the file name and path
	    print "$file\n";
	}
}