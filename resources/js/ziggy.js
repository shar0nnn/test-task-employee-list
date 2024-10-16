const Ziggy = {
    "url": "http:\/\/localhost",
    "port": null,
    "defaults": {},
    "routes": {
        "livewire.update": {"uri": "livewire\/update", "methods": ["POST"]},
        "livewire.upload-file": {"uri": "livewire\/upload-file", "methods": ["POST"]},
        "livewire.preview-file": {
            "uri": "livewire\/preview-file\/{filename}",
            "methods": ["GET", "HEAD"],
            "parameters": ["filename"]
        },
        "login-component.show": {"uri": "login", "methods": ["GET", "HEAD"]},
        "login": {"uri": "login", "methods": ["POST"]},
        "employees.index": {"uri": "employees\/list", "methods": ["GET", "HEAD"]},
        "employees.get": {"uri": "employees\/get", "methods": ["GET", "HEAD"]},
        "positions.index": {"uri": "positions\/list", "methods": ["GET", "HEAD"]},
        "logout": {"uri": "logout", "methods": ["GET", "HEAD"]},
        "storage.local": {
            "uri": "storage\/{path}",
            "methods": ["GET", "HEAD"],
            "wheres": {"path": ".*"},
            "parameters": ["path"]
        }
    }
};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export {Ziggy};
