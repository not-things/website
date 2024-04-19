# Visitor count database
- Binary format should look like this:
  - First entry should have the index to the first free entry, or EOL
  - Subsequent entries store the visitor count
    - 8 bits (256) for the TTL
    - 24 bits (16 mil) for the visitor count
- Free list pointer
  - A freed entry should be appended to the free list by changing the first entry to its index, and then that entry should store the index of the old first free entry
  - A free entry can be used by setting the first entry to the index pointed to by the free entry, and then entering the appropriate data
- Daily traversal of the list to find any entries that have exceeded their TTL and add them to the free list
- Lock file during modification (use `flock`)
- Accesses should increment the visitor count and the TTL

## Binary data manipulation class
Make a class that helps do this more easily.

# Header and footer generator
Generate header and footer HTML for the blog files.
- This should be done with a script either when Emacs is building the files, or before Parcel starts building.
- Write it in Python? Or Shell, Perl