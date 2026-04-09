export function computeFees(grossAmount) {
  const gross = Number(grossAmount);
  const platformFee = round2(gross * 0.1);
  const net = round2(gross - platformFee);
  return { gross, platformFee, net };
}

function round2(n) {
  return Math.round((Number(n) + Number.EPSILON) * 100) / 100;
}

