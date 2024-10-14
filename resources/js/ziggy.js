const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"login-component.show":{"uri":"login","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["POST"]},"employees.index":{"uri":"employees\/list","methods":["GET","HEAD"]},"positions.index":{"uri":"positions\/list","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["GET","HEAD"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
