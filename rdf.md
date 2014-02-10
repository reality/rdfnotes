==RDF - Resource Description Framework==

* Language for representing metadata about resources on the WWW.
* Intended for solutions in which the information needs to be processed by
  applications.
* Represent simple statements about resources in terms of simple propertiesand
  property values.
* RDF also provides an XML-based syntax called RDF/XML for recording and
  exchanging the 'graphs.'
* Based on the idea that things being described have properties which have 
  values, and that resources can be described by making statements that 
  specify those properties and values.
* Concepts:
    * Subject - URL
    * Predicate - Property
    * Object - Value
* RDF uses URIs as the basis of its mechanism for identifying subjects, predicates and objects
* Triples notation <subject> <predicate> <object>

http://www.example.org/index.html has a creator whose value is John Smith

* URIRef useful for objects, better identification. Provides fully-fledged
  resource. Can add more RDF statements using URIRef Object as Subject.
* Also useful because it defines the *type* of use. e.g. define variable name vs
  human name.
* Note people can use different URIs to refer to the same thing. Best to use an
  already-defined vocabulary.

* RDF applies no intrinsic meaning to any data. It only describes the
  relationships.

* Structured information is described by making a new Subject node. URIRef
  identifies the parent - aggregate concepts.
* This can apparently also be done with a blank node (undefined object for aggregate parent).
    * Triples notation uses format _:whatever to denote differentiated blank
      nodes.
    * Blank node identifiers cannot be used as inter-graph identifiers. Cannot
      be used as predicates.
    * Useful to make statements about resources which don't have URIs, but are
      described in terms of relationships with other resources which do have
      URIs.
* RDF only describes binary relationships. To describe n-ary relationships, it
  must be broken up into a group of separate binary relationships.

* Typed literals denote a datatype e.g. exterms:age "27"^^xsd:integer
* This can be a URIref
* RDF itself does not confirm the validity of the datatype

Sources:
* RDF Primer - http://www.w3.org/TR/rdf-primer/
