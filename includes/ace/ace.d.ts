/// <reference path="./ace-modules.d.ts" />
export namespace Ace {
  export type NewLineMode = 'auto' | 'unix' | 'windows';

  export interface Anchor extends EventEmitter {
    getPosition(): Point;
    getDocument(): Document;
    setPosition(row: number, column: number, noClip?: boolean);
    detach();
    attach(doc: Document);
  }

  export interface Document extends EventEmitter {
    setValue(text: string);
    getValue(): string;
    createAnchor(row: number, column: number): Anchor;
    getNewLineCharacter(): string;
    setNewLineMode(newLineMode: NewLineMode);
    getNewLineMode(): NewLineMode;
    isNewLine(text: string): boolean;
    getLine(row: number): string;
    getLines(firstRow: number, lastRow: number): string[];
    getAllLines(): string[];
    getLength(): number;
    getTextRange(range: Range): string;
    getLinesForRange(range: Range): string[];
    insert(position: Point, text: string): Point;
    insertInLine(position: Point, text: string): Point;
    insertNewLine(position: Point): Point;
    clippedPos(row: number, column: number): Point;
    clonePos(pos: Point): Point;
    pos(row: number, column: number): Point;
    insertFullLines(row: number, lines: string[]);
    insertMergedLines(position: Point, lines: string[]): Point;
    remove(range: Range): Point;
    removeInLine(row: number, startColumn: number, endColumn: number): Point;
    removeFullLines(firstRow: number, lastRow: number): string[];
    removeNewLine(row: number);
    replace(range: Range, text: string): Point;
    applyDeltas(deltas: Delta[]);
    revertDeltas(deltas: Delta[]);
    applyDelta(delta: Delta, doNotValidate?: boolean);
    revertDelta(delta: Delta);
    indexToPosition(index: number, startRow: number): Point;
    positionToIndex(pos: Point, startRow?: number): number;
  }

  export interface FoldLine {
    folds: Fold[];
    range: Range;
    start: Point;
    end: Point;

    shiftRow(shift: number);
    addFold(fold: Fold);
    containsRow(row: number): boolean;
    walk(callback: Function, endRow?: number, endColumn?: number);
    getNextFoldTo(row: number, column: number): null | { fold: Fold, kind: string };
    addRemoveChars(row: number, column: number, len: number);
    split(row: number, column: number): FoldLine;
    merge(foldLineNext: FoldLine);
    idxToPosition(idx: number): Point;
  }

  export interface Fold {
    range: Range;
    start: Point;
    end: Point;
    foldLine?: FoldLine;
    sameRow: boolean;
    subFolds: Fold[];

    setFoldLine(foldLine: FoldLine);
    clone(): Fold;
    addSubFold(fold: Fold): Fold;
    restoreRange(range: Range);
  }

  interface Folding {
    getFoldAt(row: number, column: number, side: number): Fold;
    getFoldsInRange(range: Range): Fold[];
    getFoldsInRangeList(ranges: Range[]): Fold[];
    getAllFolds(): Fold[];
    getFoldStringAt(row: number,
      column: number,
      trim?: number,
      foldLine?: FoldLine): string | null;
    getFoldLine(docRow: number, startFoldLine?: FoldLine): FoldLine | null;
    getNextFoldLine(docRow: number, startFoldLine?: FoldLine): FoldLine | null;
    getFoldedRowCount(first: number, last: number): number;
    addFold(placeholder: string | Fold, range?: Range): Fold;
    addFolds(folds: Fold[]);
    removeFold(fold: Fold);
    removeFolds(folds: Fold[]);
    expandFold(fold: Fold);
    expandFolds(folds: Fold[]);
    unfold(location: null | number | Point | Range,
      expandInner?: boolean): Fold[] | undefined;
    isRowFolded(docRow: number, startFoldRow?: FoldLine): boolean;
    getFoldRowEnd(docRow: number, startFoldRow?: FoldLine): number;
    getFoldRowStart(docRow: number, startFoldRow?: FoldLine): number;
    getFoldDisplayLine(foldLine: FoldLine,
      endRow: number | null,
      endColumn: number | null,
      startRow: number | null,
      startColumn: number | null): string;
    getDisplayLine(row: number,
      endColumn: number | null,
      startRow: number | null,
      startColumn: number | null): string;
    toggleFold(tryToUnfold?: boolean);
    getCommentFoldRange(row: number,
      column: number,
      dir: number): Range | undefined;
    foldAll(startRow?: number, endRow?: number, depth?: number);
    setFoldStyle(style: string);
    getParentFoldRangeData(row: number, ignoreCurrent?: boolean): {
      range?: Range,
      firstRange: Range
    };
    toggleFoldWidget(toggleParent?: boolean);
    updateFoldWidgets(delta: Delta);
  }

  export interface Range {
    start: Point;
    end: Point;

    isEqual(range: Range): boolean;
    toString(): string;
    contains(row: number, column: number): boolean;
    compareRange(range: Range): number;
    comparePoint(p: Point): number;
    containsRange(range: Range): boolean;
    intersects(range: Range): boolean;
    isEnd(row: number, column: number): boolean;
    isStart(row: number, column: number): boolean;
    setStart(row: number, column: number);
    setEnd(row: number, column: number);
    inside(row: number, column: number): boolean;
    insideStart(row: number, column: number): boolean;
    insideEnd(row: number, column: number): boolean;
    compare(row: number, column: number): number;
    compareStart(row: number, column: number): number;
    compareEnd(row: number, column: number): number;
    compareInside(row: number, column: number): number;
    clipRows(firstRow: number, lastRow: number): Range;
    extend(row: number, column: number): Range;
    isEmpty(): boolean;
    isMultiLine(): boolean;
    clone(): Range;
    collapseRows(): Range;
    toScreenRange(session: EditSession): Range;
    moveBy(row: number, column: number);
  }

  export interface EditSessionOptions {
    wrap: "off" | "free" | "printmargin" | boolean | number;
    wrapMethod: 'code' | 'text' | 'auto';
    indentedSoftWrap: boolean;
    firstLineNumber: number;
    useWorker: boolean;
    useSoftTabs: boolean;
    tabSize: number;
    navigateWithinSoftTabs: boolean;
    foldStyle: 'markbegin' | 'markbeginend' | 'manual';
    overwrite: boolean;
    newLineMode: NewLineMode;
    mode: string;
  }

  export interface VirtualRendererOptions {
    animatedScroll: boolean;
    showInvisibles: boolean;
    showPrintMargin: boolean;
    printMarginColumn: number;
    printMargin: boolean | number;
    showGutter: boolean;
    fadeFoldWidgets: boolean;
    showFoldWidgets: boolean;
    showLineNumbers: boolean;
    displayIndentGuides: boolean;
    highlightGutterLine: boolean;
    hScrollBarAlwaysVisible: boolean;
    vScrollBarAlwaysVisible: boolean;
    fontSize: number;
    fontFamily: string;
    maxLines: number;
    minLines: number;
    scrollPastEnd: boolean;
    fixedWidthGutter: boolean;
    theme: string;
    hasCssTransforms: boolean;
    maxPixelHeight: number;
  }

  export interface MouseHandlerOptions {
    scrollSpeed: number;
    dragDelay: number;
    dragEnabled: boolean;
    focusTimeout: number;
    tooltipFollowsMouse: boolean;
  }

  export interface EditorOptions extends EditSessionOptions,
    MouseHandlerOptions,
    VirtualRendererOptions {
    selectionStyle: string;
    highlightActiveLine: boolean;
    highlightSelectedWord: boolean;
    readOnly: boolean;
    copyWithEmptySelection: boolean;
    cursorStyle: 'ace' | 'slim' | 'smooth' | 'wide';
    mergeUndoDeltas: true | false | 'always';
    behavioursEnabled: boolean;
    wrapBehavioursEnabled: boolean;
    enableAutoIndent: boolean;
    autoScrollEditorIntoView: boolean;
    keyboardHandler: string;
    placeholder: string;
    value: string;
    session: EditSession;
  }

  export interface SearchOptions {
    needle: string | RegExp;
    preventScroll: boolean;
    backwards: boolean;
    start: Range;
    skipCurrent: boolean;
    range: Range;
    preserveCase: boolean;
    regExp: RegExp;
    wholeWord: boolean;
    caseSensitive: boolean;
    wrap: boolean;
  }

  export interface EventEmitter {
    once(name: string, callback: Function);
    setDefaultHandler(name: string, callback: Function);
    removeDefaultHandler(name: string, callback: Function);
    on(name: string, callback: Function, capturing?: boolean);
    addEventListener(name: string, callback: Function, capturing?: boolean);
    off(name: string, callback: Function);
    removeListener(name: string, callback: Function);
    removeEventListener(name: string, callback: Function);
  }

  export interface Point {
    row: number;
    column: number;
  }

  export interface Delta {
    action: 'insert' | 'remove';
    start: Point;
    end: Point;
    lines: string[];
  }

  export interface Annotation {
    row?: number;
    column?: number;
    text: string;
    type: string;
  }

  export interface Command {
    name?: string;
    bindKey?: string | { mac?: string, win?: string };
    readOnly?: boolean;
    exec: (editor: Editor, args?: any) => void;
  }

  export type CommandLike = Command | ((editor: Editor) => void);

  export interface KeyboardHandler {
    handleKeyboard: Function;
  }

  export interface MarkerLike {
    range: Range;
    type: string;
    renderer?: MarkerRenderer;
    clazz: string;
    inFront: boolean;
    id: number;
    update?: (html: string[],
      // TODO maybe define Marker class
      marker: any,
      session: EditSession,
      config: any) => void;
  }

  export type MarkerRenderer = (html: string[],
    range: Range,
    left: number,
    top: number,
    config: any) => void;

  export interface Token {
    type: string;
    value: string;
    index?: number;
    start?: number;
  }

  export interface Completion {
    value: string;
    score: number;
    meta?: string;
    name?: string;
    caption?: string;
  }

  export interface Tokenizer {
    removeCapturingGroups(src: string): string;
    createSplitterRegexp(src: string, flag?: string): RegExp;
    getLineTokens(line: string, startState: string | string[]): Token[];
  }

  interface TokenIterator {
    getCurrentToken(): Token;
    getCurrentTokenColumn(): number;
    getCurrentTokenRow(): number;
    getCurrentTokenPosition(): Point;
    getCurrentTokenRange(): Range;
    stepBackward(): Token;
    stepForward(): Token;
  }

  export interface SyntaxMode {
    getTokenizer(): Tokenizer;
    toggleCommentLines(state: any,
      session: EditSession,
      startRow: number,
      endRow: number);
    toggleBlockComment(state: any,
      session: EditSession,
      range: Range,
      cursor: Point);
    getNextLineIndent(state: any, line: string, tab: string): string;
    checkOutdent(state: any, line: string, input: string): boolean;
    autoOutdent(state: any, doc: Document, row: number);
    // TODO implement WorkerClient types
    createWorker(session: EditSession): any;
    createModeDelegates(mapping: { [key: string]: string });
    transformAction(state: string,
      action: string,
      editor: Editor,
      session: EditSession,
      text: string): any;
    getKeywords(append?: boolean): Array<string | RegExp>;
    getCompletions(state: string,
      session: EditSession,
      pos: Point,
      prefix: string): Completion[];
  }

  export interface Config {
    get(key: string): any;
    set(key: string, value: any);
    all(): { [key: string]: any };
    moduleUrl(name: string, component?: string): string;
    setModuleUrl(name: string, subst: string): string;
    loadModule(moduleName: string | [string, string],
      onLoad?: (module: any) => void);
    init(packaged: any): any;
    defineOptions(obj: any, path: string, options: { [key: string]: any }): Config;
    resetOptions(obj: any);
    setDefaultValue(path: string, name: string, value: any);
    setDefaultValues(path: string, optionHash: { [key: string]: any });
  }

  export interface OptionsProvider {
    setOptions(optList: { [key: string]: any });
    getOptions(optionNames?: string[] | { [key: string]: any }): { [key: string]: any };
    setOption(name: string, value: any);
    getOption(name: string): any;
  }

  export interface UndoManager {
    addSession(session: EditSession);
    add(delta: Delta, allowMerge: boolean, session: EditSession);
    addSelection(selection: string, rev?: number);
    startNewGroup();
    markIgnored(from: number, to?: number);
    getSelection(rev: number, after?: boolean): { value: string, rev: number };
    getRevision(): number;
    getDeltas(from: number, to?: number): Delta[];
    undo(session: EditSession, dontSelect?: boolean);
    redo(session: EditSession, dontSelect?: boolean);
    reset();
    canUndo(): boolean;
    canRedo(): boolean;
    bookmark(rev?: number);
    isAtBookmark(): boolean;
  }

  export interface EditSession extends EventEmitter, OptionsProvider, Folding {
    selection: Selection;

    // TODO: define BackgroundTokenizer

    on(name: 'changeFold',
      callback: (obj: { data: Fold, action: string }) => void): Function;
    on(name: 'changeScrollLeft', callback: (scrollLeft: number) => void): Function;
    on(name: 'changeScrollTop', callback: (scrollTop: number) => void): Function;
    on(name: 'tokenizerUpdate',
      callback: (obj: { data: { first: number, last: number } }) => void): Function;


    setOption<T extends keyof EditSessionOptions>(name: T, value: EditSessionOptions[T]);
    getOption<T extends keyof EditSessionOptions>(name: T): EditSessionOptions[T];

    setDocument(doc: Document);
    getDocument(): Document;
    resetCaches();
    setValue(text: string);
    getValue(): string;
    getSelection(): Selection;
    getState(row: number): string;
    getTokens(row: number): Token[];
    getTokenAt(row: number, column: number): Token | null;
    setUndoManager(undoManager: UndoManager);
    markUndoGroup();
    getUndoManager(): UndoManager;
    getTabString(): string;
    setUseSoftTabs(val: boolean);
    getUseSoftTabs(): boolean;
    setTabSize(tabSize: number);
    getTabSize(): number;
    isTabStop(position: Point): boolean;
    setNavigateWithinSoftTabs(navigateWithinSoftTabs: boolean);
    getNavigateWithinSoftTabs(): boolean;
    setOverwrite(overwrite: boolean);
    getOverwrite(): boolean;
    toggleOverwrite();
    addGutterDecoration(row: number, className: string);
    removeGutterDecoration(row: number, className: string);
    getBreakpoints(): string[];
    setBreakpoints(rows: number[]);
    clearBreakpoints();
    setBreakpoint(row: number, className: string);
    clearBreakpoint(row: number);
    addMarker(range: Range,
      className: string,
      type: "fullLine" | "screenLine" | "text" | MarkerRenderer,
      inFront?: boolean): number;
    addDynamicMarker(marker: MarkerLike, inFront: boolean): MarkerLike;
    removeMarker(markerId: number);
    getMarkers(inFront?: boolean): MarkerLike[];
    highlight(re: RegExp);
    highlightLines(startRow: number,
      endRow: number,
      className: string,
      inFront?: boolean): Range;
    setAnnotations(annotations: Annotation[]);
    getAnnotations(): Annotation[];
    clearAnnotations();
    getWordRange(row: number, column: number): Range;
    getAWordRange(row: number, column: number): Range;
    setNewLineMode(newLineMode: NewLineMode);
    getNewLineMode(): NewLineMode;
    setUseWorker(useWorker: boolean);
    getUseWorker(): boolean;
    setMode(mode: string | SyntaxMode, callback?: () => void);
    getMode(): SyntaxMode;
    setScrollTop(scrollTop: number);
    getScrollTop(): number;
    setScrollLeft(scrollLeft: number);
    getScrollLeft(): number;
    getScreenWidth(): number;
    getLineWidgetMaxWidth(): number;
    getLine(row: number): string;
    getLines(firstRow: number, lastRow: number): string[];
    getLength(): number;
    getTextRange(range: Range): string;
    insert(position: Point, text: string);
    remove(range: Range);
    removeFullLines(firstRow: number, lastRow: number);
    undoChanges(deltas: Delta[], dontSelect?: boolean);
    redoChanges(deltas: Delta[], dontSelect?: boolean);
    setUndoSelect(enable: boolean);
    replace(range: Range, text: string);
    moveText(fromRange: Range, toPosition: Point, copy?: boolean);
    indentRows(startRow: number, endRow: number, indentString: string);
    outdentRows(range: Range);
    moveLinesUp(firstRow: number, lastRow: number);
    moveLinesDown(firstRow: number, lastRow: number);
    duplicateLines(firstRow: number, lastRow: number);
    setUseWrapMode(useWrapMode: boolean);
    getUseWrapMode(): boolean;
    setWrapLimitRange(min: number, max: number);
    adjustWrapLimit(desiredLimit: number): boolean;
    getWrapLimit(): number;
    setWrapLimit(limit: number);
    getWrapLimitRange(): { min: number, max: number };
    getRowLineCount(row: number): number;
    getRowWrapIndent(screenRow: number): number;
    getScreenLastRowColumn(screenRow: number): number;
    getDocumentLastRowColumn(docRow: number, docColumn: number): number;
    getdocumentLastRowColumnPosition(docRow: number, docColumn: number): Point;
    getRowSplitData(row: number): string | undefined;
    getScreenTabSize(screenColumn: number): number;
    screenToDocumentRow(screenRow: number, screenColumn: number): number;
    screenToDocumentColumn(screenRow: number, screenColumn: number): number;
    screenToDocumentPosition(screenRow: number,
      screenColumn: number,
      offsetX?: number): Point;
    documentToScreenPosition(docRow: number, docColumn: number): Point;
    documentToScreenPosition(position: Point): Point;
    documentToScreenColumn(row: number, docColumn: number): number;
    documentToScreenRow(docRow: number, docColumn: number): number;
    getScreenLength(): number;
    destroy();
  }

  export interface KeyBinding {
    setDefaultHandler(handler: KeyboardHandler);
    setKeyboardHandler(handler: KeyboardHandler);
    addKeyboardHandler(handler: KeyboardHandler, pos: number);
    removeKeyboardHandler(handler: KeyboardHandler): boolean;
    getKeyboardHandler(): KeyboardHandler;
    getStatusText(): string;
    onCommandKey(e: any, hashId: number, keyCode: number): boolean;
    onTextInput(text: string): boolean;
  }

  interface CommandMap {
    [name: string]: Command;
  }

  type execEventHandler = (obj: {
    editor: Editor,
    command: Command,
    args: any[]
  }) => void;

  export interface CommandManager extends EventEmitter {
    byName: CommandMap,
    commands: CommandMap,
    on(name: 'exec', callback: execEventHandler): Function;
    on(name: 'afterExec', callback: execEventHandler): Function;
    once(name: string, callback: Function);
    setDefaultHandler(name: string, callback: Function);
    removeDefaultHandler(name: string, callback: Function);
    on(name: string, callback: Function, capturing?: boolean): Function;
    addEventListener(name: string, callback: Function, capturing?: boolean);
    off(name: string, callback: Function);
    removeListener(name: string, callback: Function);
    removeEventListener(name: string, callback: Function);

    exec(command: string, editor: Editor, args: any): boolean;
    toggleRecording(editor: Editor);
    replay(editor: Editor);
    addCommand(command: Command);
    addCommands(command: Command[]);
    removeCommand(command: Command | string, keepCommand?: boolean);
    removeCommands(command: Command[]);
    bindKey(key: string | { mac?: string, win?: string },
      command: CommandLike,
      position?: number);
    bindKeys(keys: {[s: string]: Function});
    parseKeys(keyPart: string): {key: string, hashId: number};
    findKeyCommand(hashId: number, keyString: string): string | undefined;
    handleKeyboard(data: {}, hashId: number, keyString: string, keyCode: string | number) | {command: string};
    getStatusText(editor: Editor, data: {}): string;
  }

  export interface VirtualRenderer extends OptionsProvider, EventEmitter {
    container: HTMLElement;

    setOption<T extends keyof VirtualRendererOptions>(name: T, value: VirtualRendererOptions[T]);
    getOption<T extends keyof VirtualRendererOptions>(name: T): VirtualRendererOptions[T];

    setSession(session: EditSession);
    updateLines(firstRow: number, lastRow: number, force?: boolean);
    updateText();
    updateFull(force?: boolean);
    updateFontSize();
    adjustWrapLimit(): boolean;
    setAnimatedScroll(shouldAnimate: boolean);
    getAnimatedScroll(): boolean;
    setShowInvisibles(showInvisibles: boolean);
    getShowInvisibles(): boolean;
    setDisplayIndentGuides(display: boolean);
    getDisplayIndentGuides(): boolean;
    setShowPrintMargin(showPrintMargin: boolean);
    getShowPrintMargin(): boolean;
    setPrintMarginColumn(showPrintMargin: boolean);
    getPrintMarginColumn(): boolean;
    setShowGutter(show: boolean);
    getShowGutter(): boolean;
    setFadeFoldWidgets(show: boolean);
    getFadeFoldWidgets(): boolean;
    setHighlightGutterLine(shouldHighlight: boolean);
    getHighlightGutterLine(): boolean;
    getContainerElement(): HTMLElement;
    getMouseEventTarget(): HTMLElement;
    getTextAreaContainer(): HTMLElement;
    getFirstVisibleRow(): number;
    getFirstFullyVisibleRow(): number;
    getLastFullyVisibleRow(): number;
    getLastVisibleRow(): number;
    setPadding(padding: number);
    setScrollMargin(top: number,
      bottom: number,
      left: number,
      right: number);
    setHScrollBarAlwaysVisible(alwaysVisible: boolean);
    getHScrollBarAlwaysVisible(): boolean;
    setVScrollBarAlwaysVisible(alwaysVisible: boolean);
    getVScrollBarAlwaysVisible(): boolean;
    freeze();
    unfreeze();
    updateFrontMarkers();
    updateBackMarkers();
    updateBreakpoints();
    setAnnotations(annotations: Annotation[]);
    updateCursor();
    hideCursor();
    showCursor();
    scrollSelectionIntoView(anchor: Point,
      lead: Point,
      offset?: number);
    scrollCursorIntoView(cursor: Point, offset?: number);
    getScrollTop(): number;
    getScrollLeft(): number;
    getScrollTopRow(): number;
    getScrollBottomRow(): number;
    scrollToRow(row: number);
    alignCursor(cursor: Point | number, alignment: number): number;
    scrollToLine(line: number,
      center: boolean,
      animate: boolean,
      callback: () => void);
    animateScrolling(fromValue: number, callback: () => void);
    scrollToY(scrollTop: number);
    scrollToX(scrollLeft: number);
    scrollTo(x: number, y: number);
    scrollBy(deltaX: number, deltaY: number);
    isScrollableBy(deltaX: number, deltaY: number): boolean;
    textToScreenCoordinates(row: number, column: number): { pageX: number, pageY: number };
    visualizeFocus();
    visualizeBlur();
    showComposition(position: number);
    setCompositionText(text: string);
    hideComposition();
    setTheme(theme: string, callback?: () => void);
    getTheme(): string;
    setStyle(style: string, include?: boolean);
    unsetStyle(style: string);
    setCursorStyle(style: string);
    setMouseCursor(cursorStyle: string);
    attachToShadowRoot();
    destroy();
  }


  export interface Selection extends EventEmitter {
    moveCursorWordLeft();
    moveCursorWordRight();
    fromOrientedRange(range: Range);
    setSelectionRange(match: any);
    getAllRanges(): Range[];
    addRange(range: Range);
    isEmpty(): boolean;
    isMultiLine(): boolean;
    setCursor(row: number, column: number);
    setAnchor(row: number, column: number);
    getAnchor(): Point;
    getCursor(): Point;
    isBackwards(): boolean;
    getRange(): Range;
    clearSelection();
    selectAll();
    setRange(range: Range, reverse?: boolean);
    selectTo(row: number, column: number);
    selectToPosition(pos: any);
    selectUp();
    selectDown();
    selectRight();
    selectLeft();
    selectLineStart();
    selectLineEnd();
    selectFileEnd();
    selectFileStart();
    selectWordRight();
    selectWordLeft();
    getWordRange();
    selectWord();
    selectAWord();
    selectLine();
    moveCursorUp();
    moveCursorDown();
    moveCursorLeft();
    moveCursorRight();
    moveCursorLineStart();
    moveCursorLineEnd();
    moveCursorFileEnd();
    moveCursorFileStart();
    moveCursorLongWordRight();
    moveCursorLongWordLeft();
    moveCursorBy(rows: number, chars: number);
    moveCursorToPosition(position: any);
    moveCursorTo(row: number, column: number, keepDesiredColumn?: boolean);
    moveCursorToScreen(row: number, column: number, keepDesiredColumn: boolean);

    toJSON(): SavedSelection | SavedSelection[];
    fromJSON(selection: SavedSelection | SavedSelection[]);
  }
  interface SavedSelection {
    start: Point;
    end: Point;
    isBackwards: boolean;
  }

  var Selection: {
    new(session: EditSession): Selection;
  }

  export interface Editor extends OptionsProvider, EventEmitter {
    container: HTMLElement;
    renderer: VirtualRenderer;
    id: string;
    commands: CommandManager;
    keyBinding: KeyBinding;
    session: EditSession;
    selection: Selection;

    on(name: 'blur', callback: (e: Event) => void): Function;
    on(name: 'input', callback: () => void): Function;
    on(name: 'change', callback: (delta: Delta) => void): Function;
    on(name: 'changeSelectionStyle', callback: (obj: { data: string }) => void): Function;
    on(name: 'changeSession',
      callback: (obj: { session: EditSession, oldSession: EditSession }) => void
    ): Function;
    on(name: 'copy', callback: (obj: { text: string }) => void): Function;
    on(name: 'focus', callback: (e: Event) => void): Function;
    on(name: 'paste', callback: (obj: { text: string }) => void): Function;

    setOption<T extends keyof EditorOptions>(name: T, value: EditorOptions[T]);
    getOption<T extends keyof EditorOptions>(name: T): EditorOptions[T];

    setKeyboardHandler(keyboardHandler: string, callback?: () => void);
    getKeyboardHandler(): string;
    setSession(session: EditSession);
    getSession(): EditSession;
    setValue(val: string, cursorPos?: number): string;
    getValue(): string;
    getSelection(): Selection;
    resize(force?: boolean);
    setTheme(theme: string, callback?: () => void);
    getTheme(): string;
    setStyle(style: string);
    unsetStyle(style: string);
    getFontSize(): string;
    setFontSize(size: string);
    focus();
    isFocused(): boolean;
    blur();
    getSelectedText(): string;
    getCopyText(): string;
    execCommand(command: string | string[], args?: any): boolean;
    insert(text: string, pasted?: boolean);
    setOverwrite(overwrite: boolean);
    getOverwrite(): boolean;
    toggleOverwrite();
    setScrollSpeed(speed: number);
    getScrollSpeed(): number;
    setDragDelay(dragDelay: number);
    getDragDelay(): number;
    setSelectionStyle(val: string);
    getSelectionStyle(): string;
    setHighlightActiveLine(shouldHighlight: boolean);
    getHighlightActiveLine(): boolean;
    setHighlightGutterLine(shouldHighlight: boolean);
    getHighlightGutterLine(): boolean;
    setHighlightSelectedWord(shouldHighlight: boolean);
    getHighlightSelectedWord(): boolean;
    setAnimatedScroll(shouldAnimate: boolean);
    getAnimatedScroll(): boolean;
    setShowInvisibles(showInvisibles: boolean);
    getShowInvisibles(): boolean;
    setDisplayIndentGuides(display: boolean);
    getDisplayIndentGuides(): boolean;
    setShowPrintMargin(showPrintMargin: boolean);
    getShowPrintMargin(): boolean;
    setPrintMarginColumn(showPrintMargin: number);
    getPrintMarginColumn(): number;
    setReadOnly(readOnly: boolean);
    getReadOnly(): boolean;
    setBehavioursEnabled(enabled: boolean);
    getBehavioursEnabled(): boolean;
    setWrapBehavioursEnabled(enabled: boolean);
    getWrapBehavioursEnabled(): boolean;
    setShowFoldWidgets(show: boolean);
    getShowFoldWidgets(): boolean;
    setFadeFoldWidgets(fade: boolean);
    getFadeFoldWidgets(): boolean;
    remove(dir?: 'left' | 'right');
    removeWordRight();
    removeWordLeft();
    removeLineToEnd();
    splitLine();
    transposeLetters();
    toLowerCase();
    toUpperCase();
    indent();
    blockIndent();
    blockOutdent();
    sortLines();
    toggleCommentLines();
    toggleBlockComment();
    modifyNumber(amount: number);
    removeLines();
    duplicateSelection();
    moveLinesDown();
    moveLinesUp();
    moveText(range: Range, toPosition: Point, copy?: boolean): Range;
    copyLinesUp();
    copyLinesDown();
    getFirstVisibleRow(): number;
    getLastVisibleRow(): number;
    isRowVisible(row: number): boolean;
    isRowFullyVisible(row: number): boolean;
    selectPageDown();
    selectPageUp();
    gotoPageDown();
    gotoPageUp();
    scrollPageDown();
    scrollPageUp();
    scrollToRow(row: number);
    scrollToLine(line: number, center: boolean, animate: boolean, callback: () => void);
    centerSelection();
    getCursorPosition(): Point;
    getCursorPositionScreen(): Point;
    getSelectionRange(): Range;
    selectAll();
    clearSelection();
    moveCursorTo(row: number, column: number);
    moveCursorToPosition(pos: Point);
    jumpToMatching(select: boolean, expand: boolean);
    gotoLine(lineNumber: number, column: number, animate: boolean);
    navigateTo(row: number, column: number);
    navigateUp();
    navigateDown();
    navigateLeft();
    navigateRight();
    navigateLineStart();
    navigateLineEnd();
    navigateFileEnd();
    navigateFileStart();
    navigateWordRight();
    navigateWordLeft();
    replace(replacement: string, options?: Partial<SearchOptions>): number;
    replaceAll(replacement: string, options?: Partial<SearchOptions>): number;
    getLastSearchOptions(): Partial<SearchOptions>;
    find(needle: string | RegExp, options?: Partial<SearchOptions>, animate?: boolean): Ace.Range | undefined;
    findNext(options?: Partial<SearchOptions>, animate?: boolean);
    findPrevious(options?: Partial<SearchOptions>, animate?: boolean);
    findAll(needle: string | RegExp, options?: Partial<SearchOptions>, additive?: boolean): number;
    undo();
    redo();
    destroy();
    setAutoScrollEditorIntoView(enable: boolean);
    completers: Completer[];
  }

  type CompleterCallback = (error: any, completions: Completion[]) => void;

  interface Completer {
    identifierRegexps?: Array<RegExp>,
    getCompletions(editor: Editor,
      session: EditSession,
      position: Point,
      prefix: string,
      callback: CompleterCallback);
  }
}


export const version: string;
export const config: Ace.Config;
export function require(name: string): any;
export function edit(el: Element | string, options?: Partial<Ace.EditorOptions>): Ace.Editor;
export function createEditSession(text: Ace.Document | string, mode: Ace.SyntaxMode): Ace.EditSession;
export const VirtualRenderer: {
  new(container: HTMLElement, theme?: string): Ace.VirtualRenderer;
};
export const EditSession: {
  new(text: string | Document, mode?: Ace.SyntaxMode): Ace.EditSession;
};
export const UndoManager: {
  new(): Ace.UndoManager;
};
export const Range: {
  new(startRow: number, startColumn: number, endRow: number, endColumn: number): Ace.Range;
  fromPoints(start: Ace.Point, end: Ace.Point): Ace.Range;
  comparePoints(p1: Ace.Point, p2: Ace.Point): number;
};
