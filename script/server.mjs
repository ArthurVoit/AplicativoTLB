import { createServer } from 'node:http';
import { readFileSync } from 'node:fs';

const html = readFileSync('../public/mapa.html', 'utf8');

const server = createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/html' });
  res.end(html);
});

server.listen(3000, '127.0.0.1', () => {
  console.log('Listening on 127.0.0.1:3000');
});