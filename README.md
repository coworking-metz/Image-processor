# Image processor for supabase (and other systems in the future)
The point is to act as a gateway between visitors and media uploaded on supabase. Supabase is free but with a limit in the bandwith. This gateway will help store the images in CloudFlare, which is totally free. ALl images uploaded to supabase can be accessed like this : 


Supabase URL : `https://lvsbvjweppdlhmjuqqvt.supabase.co/storage/v1/object/public/medias/medias/detente.jpg`
Gateway URL : `https://images.coworking-metz.fr/supabase/medias/medias/detente.jpg`


The system can be used for future others projects