const GEOCODE_KEY = "sls_geocode_cache_v1";

function getGeocodeCache() {
  try {
    return JSON.parse(localStorage.getItem(GEOCODE_KEY)) || {};
  } catch (error) {
    return {};
  }
}

function saveGeocodeCache(cache) {
  localStorage.setItem(GEOCODE_KEY, JSON.stringify(cache));
}

function normalizeAddress(value) {
  return (value || "").trim().toLowerCase();
}

async function geocodeAddress(address) {
  const normalized = normalizeAddress(address);
  if (!normalized) return null;

  const cache = getGeocodeCache();
  if (cache[normalized]) return cache[normalized];

  const url = `https://nominatim.openstreetmap.org/search?format=jsonv2&limit=1&q=${encodeURIComponent(address)}`;
  const response = await fetch(url, {
    headers: { Accept: "application/json" }
  });

  if (!response.ok) return null;

  const data = await response.json();
  if (!Array.isArray(data) || !data.length) return null;

  const item = data[0];
  const point = {
    lat: Number(item.lat),
    lng: Number(item.lon)
  };

  cache[normalized] = point;
  saveGeocodeCache(cache);
  return point;
}

function distanceKm(pointA, pointB) {
  if (!pointA || !pointB) return Number.POSITIVE_INFINITY;
  const toRad = (value) => (value * Math.PI) / 180;
  const earthKm = 6371;
  const dLat = toRad(pointB.lat - pointA.lat);
  const dLng = toRad(pointB.lng - pointA.lng);
  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(toRad(pointA.lat)) *
      Math.cos(toRad(pointB.lat)) *
      Math.sin(dLng / 2) *
      Math.sin(dLng / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return earthKm * c;
}
