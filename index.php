 <!DOCTYPE html>
<html>
<head>
<title>Solid Principles</title>
</head>

<body>

<strong>The Single Responsibility Principle is about actors and high level architecture. The Open/Closed Principle is about class design and feature extensions. The Liskov Substitution Principle is about subtyping and inheritance. The Interface Segregation Principle (ISP) is about business logic to clients communication.</strong>


<br />
<br />
<a href="docs/singleresponsibility.html">Single Responsibility</a><br />
<p>A class should have only one reason to change.</p><br /><br />

<a href="docs/openclosed.html">Open/Closed Principle</a><br />
<p>Software entities (classes, modules, functions, etc.) should be open for extension, but closed for modification.</p><br /><br />

<a href="docs/liskov.html">Liskov Substitution</a>
<ul>
	<li><p>Child classes should never break the parent class' type definitions.</p></li>
	<li><p>Original Definition : Let q(x) be a property provable about objects x of type T. Then q(y) should be provable for objects y of type S where S is a subtype of T.</p></li>
	<li><p>Robert Martin Definition : Subtypes must be substitutable for their base types.</p></li>
	<li><p>As simple as that, a subclass should override the parent class' methods in a way that does not break functionality from a client's point of view. Here is a simple example to demonstrate the concept.</p></li>
</ul>

<a href="docs/interfacesegregation.html">Interface Segregation Principles</a>
<ul>
	<li><p>The interface-segregation principle (ISP) states that no client should be forced to depend on methods it does not use.</p></li>
</ul>

<a href="docs/dependencyinversion">The Dependency Inversion Principle</a>
<ul>
    <li>A. High-level modules should not depend on low-level modules. Both should depend on abstractions.</li>
    <li>B. Abstractions should not depend upon details. Details should depend upon abstractions.</li>
</ul>
</body>

</html>
