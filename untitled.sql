((SELECT id FROM author WHERE first_name = "Rachel" AND last_name = "Phifer"),
 (SELECT id FROM genre WHERE type = "Fiction"), "The Language of Sparrows", 388);

(SELECT book.id FROM book 
JOIN author ON author.id = book.aid
WHERE book.title = "Inferno" AND author.first_name = "Dan" AND author.last_name = "Brown");


SELECT product.name, cart_contents.product_qty
FROM cart_contents
JOIN product ON product.id = cart_contents.product_id
WHERE product.qty_on_hand >= cart_contents.product_qty;