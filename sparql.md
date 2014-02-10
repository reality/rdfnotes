# SPARQL

SPARQL is a query language for retrieving and manipulating data stored in the
RDF format. 

## Basics

Seems to work mostly like SQL. The following example will return the object 
given under the specified subject and predicate:

```
SELECT ?object
WHERE
{
  subject predicate ?object .
}
```

The ? prefix indicates a variable piece of data, so you can make multiple
matches over subjects pretty easily - the query returning a set of solutions in
which the pattern has been matched in the dataset. You can also specify prefixes 
in a similar manner to Turtle.

```
PREFIX n: <http://nourishedcloud.com/>
SELECT ?name ?mbox
WHERE
{
  ?x n:name ?name
  ?x n:mbox ?mbox
}
```

* You can include typed RDF literals e.g. *"55"^^xsd:integer* (note that this
  example would not match *"55"* - these RDF literals are distinct).
* Query results can include blank nodes, in the form *_:x* (blank node label).

## Building Graphs

There are several query formats; SELECT (shown above) returns variable bindings
while CONSTRUCT returns an RDF graph which can be represented in a regular
triples, Turtle or RDF/XML format. For example:

```
PREFIX n: <http://nourishedcloud.com/>
CONSTRUCT { ?x n:name ?name }
WHERE { ?x n:age "55"^^xsd:integer }

```

The above query may return an RDF graph such as:

```
@prefix n: <http://nourishedcloud.com>
_:x n:name "Bat" .
_:y n:name "Man" .
```

## Term Constraints

Solution sets can be restricted by using FILTERS, which provide functionality
such as regex to test solutions.

### Strings

The regex FILTER function is used to match against plain literals (with no
language tag apparently).

```
PREFIX n: <http://nourishedcloud.com/>
SELECT ?name
WHERE {
  ?x n:name ?name
  FILTER regex(?name, "^l", "i")
}
```

The above example would return solutions in which the matched name began with
'l,' as per the given regex (passed also with a case-insensitive flag).

### Numerals

Restrictions can also be placed with arithmetic expressions:

```
PREFIX n: <http://nourishedcloud.com/>
SELECT ?name ?age
WHERE {
  ?x n:age ? age .
  FILTER (?age < 55)
  ?x n:name ?name .
}
```

## Sources

* http://en.wikipedia.org/wiki/SPARQL
* http://www.dajobe.org/2005/04-sparql/SPARQLreference-1.8.pdf
* http://www.w3.org/TR/rdf-sparql-query/
