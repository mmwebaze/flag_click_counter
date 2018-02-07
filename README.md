# Flag Click Counter

This module keeps a cummulative count of the number of clicks a flaggable content type receives. 
The major difference with the count in the Flag module is that it isn't commulative. For instance if we use 
'like' and 'unlike' as our configured flags, 'like' flag would increment counter by one and the 'unlike' 
flag would reduce the counter by one.
