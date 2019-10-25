---
---

<head>
  <title>LTSP IRC logs</title>
</head>

<body>
  <h1>LTSP IRC logs</h1>
  <p>Not ready yet; see https://github.com/ltsp/irclogs/tree/master</p>
  <ul>
    {% for url in site.static_files %}
    <li><a href="{{ site.baseurl | escape }}{{ url.path | escape }}">{{ url.path | escape }}</a> </li>
    {% endfor %}
  </ul>
</body>
