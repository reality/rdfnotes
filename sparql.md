Seems to work mostly like SQL. Simple example:

The following example will return the object given under the specified subject
and predicate:

'''
SELECT ?object
WHERE
{
  subject predicate ?object .
}
'''

The ? prefix indicates a variable piece of data, so you can make multiple
matches over subjects pretty easily - the query returning a set of solutions in
which the pattern has been matched in the dataset. You can also specify prefixes 
in a similar manner to Turtle.

'''
PREFIX g: <http://google.com/>
SELECT ?name ?mbox
WHERE
{
  ?x g:name ?name
  ?x g:mbox ?mbox
}
'''

You can also include typed RDF literals e.g. "55"^^xsd:integer (note that this
example would not match "55" - these RDF literals are distinct).
