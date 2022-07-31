// @flow

import { knownDataCenters } from '../src/knownDataCenters.js';
require('isomorphic-fetch');


test("fetch directly", () => {
  expect(knownDataCenters.knownDataCentersJsonURL).toBeDefined();
  return fetch(knownDataCenters.knownDataCentersJsonURL)
  .then(response => {
    expect(response.status).toBe(200);
    expect(response.json()).toBeDefined();
  });
});


test("load known DCs", () => {
  return knownDataCenters.getKnownDataCenters().then(knownDCs => {
    expect(knownDCs).toBeDefined();
  });
});
