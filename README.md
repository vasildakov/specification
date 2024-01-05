# PHP Specification Design Pattern

## Specification

> The central idea of Specification is to separate the statement of how to match a candidate, from the
candidate object that it is matched against. As well as its usefulness in selection, it is also valuable for
validation and for building to order.
> 
> <cite>[Eric Evans][1] and [Martin Fowler][1]</cite>

## Composite Specifications

> How do you implement a generalized specification that will give you the flexibility to express complex
requirements without implementing specialized classes for every different type of candidate? The hard
coded and parameterized specifications both use a single specification object to handle the
specification. The composite specification uses several objects arranged in the composite pattern
[Gang of Four] to do the work.
> 
> <cite>[Eric Evans][1] and [Martin Fowler][1]</cite>


## Parameterized Specification

> A Parameterized Specification allows new specifications to be built without programming, indeed at 
> run time, but you are limited as to what kind of specifications you can build by what the programmers 
> have set up.



## Links
- [Specification pattern][2], Wikipedia
- [Implementing The Specification Pattern][3], Philip Brown
- [Pattern Specification][4], Romain Pierlot
- [Composite in PHP][5], SourceMaking
- [Specification design pattern in php][6], Milad
- [Specification][7], DesignPatternsPHP

[1]: https://www.martinfowler.com/apsupp/spec.pdf
[2]: https://en.wikipedia.org/wiki/Specification_pattern
[3]: https://culttt.com/2014/08/25/implementing-specification-pattern
[4]: https://blog.eleven-labs.com/fr/pattern-specification-2/
[5]: https://sourcemaking.com/design_patterns/composite/php
[6]: https://medium.com/@miladev95/specification-design-pattern-in-php-5f392dbfe76c
[7]: https://designpatternsphp.readthedocs.io/en/latest/Behavioral/Specification/README.html