export default function imageUrl(path) {
  if (!path) return null;
  if (typeof path !== 'string') return null;
  const p = path.trim();

  // Already an absolute URL
  if (p.startsWith('http://') || p.startsWith('https://')) return p;
  // Protocol-relative URL (e.g. //cdn.example/xxx)
  if (p.startsWith('//')) return window.location.protocol + p;
  // Absolute path on current host
  if (p.startsWith('/')) return p;

  // Otherwise assume it's a storage relative path
  return '/storage/' + p;
}
