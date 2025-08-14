export function isNull(element) {
  if (element === undefined ||
      element === null ||
      element === '')
    return true;

  return false;
}
