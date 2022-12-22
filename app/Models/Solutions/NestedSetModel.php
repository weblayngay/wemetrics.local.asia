<?php

namespace App\Models\Solutions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NestedSetModel extends Model
{
    public $timestamps      = true;

    protected $params    = array();
    protected $nodeInfo  = null;

    //Những field không được update/insert theo dữ liệu người dùng truyền vào. Mà nó sẽ được tính tự động
    protected $tableFieldsNotUpdateOrInsert = array( 'parent' => '', 'level' => '', 'left' => '', 'right' => '');
    protected $tableFields;

    /**
     * Áp dụng remove only, khi xóa node cha thì node con sẽ di chuyển đến làm con của node được chỉ định
     * @var int
     */
    protected $nodePartnerId = 1;

    /**
     * @return Builder
     */
    public static function parentQuery(): Builder
    {
        return self::query();
    }

    /*
     * GET: lấy thông tin của một node hoặc anh em của một node
     * */
    public function getItemNested($params = null, $options = null){
        return self::parentQuery()->select('*')
                ->where($this->primaryKey, $params[$this->primaryKey])->first();
    }


    /*
     * INSERT: Tạo mới một node và cập nhật node liên quan
     * Tham số cần có:
     * I. paramArr
     * + 1. primaryKey(number)   = paramArr["primaryKey"] (primaryKey của node cha hoặc anh em) =>
     * + 2. data(array)  = paramArr['data'] (thông tin của node cần INSERT)
     * II. options
     * + 1. position(string) = options['position'] (Vị trí node cần thêm)
     *
     * return boolean
     * */
    public function insertNode($params = null, $options = null): bool
    {
        $this->params   = $params;
        $primaryKey     = $this->primaryKey;
        $this->nodeInfo = $this->getItemNested( ["$primaryKey" => @$this->params['parent']] );
        $parentID       = @$this->nodeInfo->$primaryKey;
        $position       = $options['position'];

        if ( in_array( $position, array( 'after', 'before' ) ) && $parentID == 1 )
            throw new \Exception( "Chèn node theo định dạng 'after hoặc before (chèn anh em)'.
			Thì node 'Root' không thể có anh em" );


        /*
         * KHÔNG THỂ THÊM NODE MỚI:
         * Nếu node cần tìm KHÔNG tồn tại hoặc vị trí cần chèn KHÔNG chính xác
         * */
        if ( $parentID < 1  || !in_array( $position, array('left', 'right', 'before', 'after' ) ) )
            throw new \Exception('Node cần tìm KHÔNG tồn tại hoặc vị trí cần chèn KHÔNG chính xác!');


        $dataLeft   = array( 'left' =>  DB::raw( '(`left` + 2)' ) );
        $dataRight  = array( 'right' => DB::raw( '(`right` + 2)' ) );
        $whereLeft  = null;
        $whereRight = null;


        // Vị trí node cần thêm
        switch ( $position ):
            case 'left': // INSERT LEFT: thêm 1 note con ở vị trí bên trái so với các node con khác
                $whereLeft  = self::parentQuery()->where('left', '>', $this->nodeInfo->left);
                $whereRight = self::parentQuery()->where('right', '>', $this->nodeInfo->left);
                $this->params['parent'] = $this->nodeInfo->$primaryKey;
                $this->params['level']  = $this->nodeInfo->level + 1;
                $this->params['left']   = $this->nodeInfo->left + 1;
                $this->params['right']  = $this->nodeInfo->left + 2;
                break;
            case 'right': // INSERT RIGHT: thêm 1 note con ở vị trí bên phải so với các node con khác
                $whereLeft   = self::parentQuery()->where('left', '>', $this->nodeInfo->right);
                $whereRight  = self::parentQuery()->where('right', '>=', $this->nodeInfo->right);
                $this->params['parent'] = $this->nodeInfo->$primaryKey;
                $this->params['level']  = $this->nodeInfo->level + 1;
                $this->params['left']   = $this->nodeInfo->right;
                $this->params['right']  = $this->nodeInfo->right + 1;
                break;
            case 'before': // INSERT BEFORE: thêm 1 note vào vị trí phía TRƯỚC và cùng cấp(level) với 1 node cụ thể đã được chỉ định
                $whereLeft   = self::parentQuery()->where('left', '>=', $this->nodeInfo->left);
                $whereRight	 = self::parentQuery()->where('right', '>', $this->nodeInfo->left);
                $this->params['parent'] = $this->nodeInfo->parent;
                $this->params['level']  = $this->nodeInfo->level;
                $this->params['left']   = $this->nodeInfo->left;
                $this->params['right']  = $this->nodeInfo->left + 1;
                break;
            case 'after': // INSERT AFTER: thêm 1 note vào vị trí phía SAU và cùng cấp(level) với 1 node cụ thể đã được chỉ định
                $whereLeft   = self::parentQuery()->where('left', '>=', $this->nodeInfo->right);
                $whereRight	 = self::parentQuery()->where('right', '>', $this->nodeInfo->right);
                $this->params['parent'] = $this->nodeInfo->parent;
                $this->params['level']  = $this->nodeInfo->level;
                $this->params['left']   = $this->nodeInfo->right + 1;
                $this->params['right']  = $this->nodeInfo->right + 2;
                break;
        endswitch;

        // Xóa những phần tử không tồn khớp với field trong columns
        $data = $this->arrayIntersectKey($this->params);



        /*
         * UPDATE: trường left và right của node
         * */
        $whereLeft->update($dataLeft);
        $whereRight->update($dataRight);


        /*
        * INSERT: node
        * */
        foreach ($data as $key => $val)
            $this->$key = $val;
        $this->save();
        return true;
    }



    /*
     * MOVE NODE: di chuyển 1 node hay nhánh tới vị trí nào đó
     * Tham số cần có:
     * I. paramArr
     * + 1. nodeMoveID(number)      = paramArr['move_item'] (id của node cần di chuyển)
     * + 2. nodeSelectionID(number) = paramArr['partner_id'] (node cần di chuyển(nodeMoveID) sẽ di chuyển tới node có primaryKey(nodeSelectionID) được chọn)
     * II. options
     * + 1. position(string) = $options['position'] (vị trí sẽ di chuyển tới)
     * */
    public function moveNode($params = null, $options = null): bool
    {
        $position = $options['position'];
        $moveItem = $params['move_item'];
        $primaryKey = $this->primaryKey;

        // Khi không thỏa điều kiện move node
        if (!in_array($position, ['right', 'left', 'before', 'after', 'move-up', 'move-down'])) return false;


        if ($position == 'move-down' || $position == 'move-up') {// khi move down or move up
            $partnerItem = $this->getItemNode( $params, [ 'task' => $position ] )    ;

            /*
             * KHÔNG THỂ MOVE DOWN OR MOVE UP NODE: vì không có node anh em liền kề
             * */
            if (@$moveItem->$primaryKey < 1 || @$partnerItem->$primaryKey <= 1)
                throw new \Exception('Không thể "move-down hoặc move-up" Node. Vì không có node anh em liền kề. ');

        }else{
            $partnerItem = $this->getItemNode(["$primaryKey" => @$params['partner_id']], ['task' => 'get-item']);
            /*
             * KHÔNG THỂ MOVE NODE: node cần di chuyển hoặc node được lựa chọn để ghép node(nhánh)
             * không tồn tại( hoặc right <= 0)
             * */

            if(in_array($position, array('before', 'after'))){
                if ($moveItem->$primaryKey < 1 || $partnerItem->$primaryKey <= 1 || $partnerItem->right < 1 ){
                    throw new \Exception('Không thể move Node: node cần di chuyển hoặc node được lựa chọn để ghép node(nhánh)
				    * không tồn tại( hoặc right <= 0) hoặc bạn lựa chọn node ROOT làm anh em');
                }
            }else{
                if ($moveItem->$primaryKey < 1 || $partnerItem->$primaryKey < 1 || $partnerItem->right < 1 ){
                    throw new \Exception('Không thể move Node: node cần di chuyển hoặc node được lựa chọn để ghép node(nhánh)
		            * không tồn tại( hoặc right <= 0)');
                } else { // KHÔNG cho phép move node cha vào node con
                    if ($moveItem->left < $partnerItem->left && $moveItem->right > $partnerItem->right) {
                        throw new \Exception('Không thể move node cha vào node con');
                    }
                }
            }

        }

        // ============================== TÁCH NHÁNH ============================
        $totalDetachNode = $this->detachBranch( array( 'detach_item' => $moveItem ) );

        // ============================== MOVE NODE ============================
        $paramArr['total_detach_node']  = $totalDetachNode;
        // Lấy lại thông tin của node(A) sẽ được move và node (B) làm cơ sở để node A move tới

        $paramArr['partner_item']       = $this->getItemNode(["$primaryKey" => $partnerItem->$primaryKey], ['task' => 'get-item']);
        $paramArr['move_item']          = $this->getItemNode(["$primaryKey" => $moveItem->$primaryKey], ['task' => 'get-item']);

        switch ($position){
            case 'left':
                $result = $this->moveLeft($paramArr, $options);
                break;
            case 'move-down':
            case 'after':
                $result = $this->moveAfter($paramArr, $options);
                break;
            case 'move-up':
            case 'before':
                $result = $this->moveBefore($paramArr, $options);
                break;
            case 'right':
            default:
                $result = $this->moveRight($paramArr, $options);
                break;
        }

        return $result;


    }

    /*
     * MOVE NODE LEFT: di chuyển 1 node hay nhánh làm con 1 node. Và nó sẽ ở vị trí bên TRÁI
     * Function chỉ được sử dụng trong moveNode()
     * @param number $paramArr['totalNodeDetach']
     * @param object $paramArr['nodeMoveInfo']
     * @param object $paramArr['nodeSelectionInfo']
     * return boolean
     * */
    private function moveLeft($params = null, $options = null): bool
    {
        $moveItem           = $params['move_item'];
        $partnerItem        = $params['partner_item'];
        $totalDetachNode    = $params['total_detach_node'];
        $primaryKey         = $this->primaryKey;


        /*
         * UPDATE LEFT ON TREE:
         * + Left = Left + totalNode*2 (left > ParentLeft & right > 0)
         * */
        $data = array( 'left'  =>  DB::raw( "(`left` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('left', '>', $partnerItem->left)
            ->where('right', '>', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON TREE:
         * + Right = Right + totalNode*2(right > ParentLeft)
         * */
        $data = array( 'right'  =>  DB::raw( "(`right` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('right', '>', $partnerItem->left)
            ->update( $data );



        /*
         * UPDATE LEVEL ON BRANCH: cập nhật node trên nhánh
         * + Level = level – nodeMoveLevel + ParentLevel +1(right <= 0)
         * */
        $data = array('level'  =>  DB::raw( "(`level` + " .  ($partnerItem->level - $moveItem->level + 1) . ")"));
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE LEFT ON BRANCH: cập nhật node trên nhánh
         * Left = left + ParentLeft + 1(right <= 0)
         * */
        $data = array( 'left'  =>  DB::raw( "(`left` + ".($partnerItem->left + 1 ).")" ) );
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON BRANCH: cập nhật node trên nhánh
         * Right = right + ParentLeft + 1 +totalNode*2 - 1(right <= 0)
         * */
        $data = array( 'right'  =>  DB::raw( "(`right` + ".($partnerItem->left + 1 + ($totalDetachNode * 2) - 1).")" ) );
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE PARENT OF NODE MOVE
         * + nodeMove[parent] = ParentID
         * */
        $data = array( 'parent' => $partnerItem->$primaryKey );
        self::parentQuery()->where("$primaryKey", '=', $moveItem->$primaryKey)
            ->update( $data );

        return true;
    }

    /*
     * MOVE NODE AFTER: di chuyển 1 node hay nhánh làm anh em 1 node. Và nó sẽ ở vị trí bên PHẢI
     * Function chỉ được sử dụng trong moveNode()
     * @param number $paramArr['totalNodeDetach']
     * @param object $paramArr['nodeMoveInfo']
     * @param object $paramArr['nodeSelectionInfo']
     * return boolean
     * */
    private function moveAfter($params = null, $options = null): bool
    {
        $moveItem           = $params['move_item'];
        $partnerItem        = $params['partner_item'];
        $totalDetachNode    = $params['total_detach_node'];
        $primaryKey         = $this->primaryKey;


        /*
         * UPDATE LEFT ON TREE:
         * Left = Left + totalNode*2(left > selectionRight & right > 0)
         * */
        $data = array( 'left'  =>  DB::raw( "(`left` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('left', '>', $partnerItem->right)
            ->where('right', '>', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON TREE:
         * + Right = Right + totalNode*2(right > selectionRight )
         * */
        $data = array( 'right'  =>  DB::raw( "(`right` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('right', '>', $partnerItem->right)
            ->update( $data );


        /*
         * UPDATE LEVEL ON BRANCH: cập nhật node trên nhánh
         * + Level = level – nodeMoveLevel + selectionLevel (right <= 0)
         * */
        $data = array('level'  =>  DB::raw( "(`level` + " .  ($partnerItem->level - $moveItem->level . ")")));
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE LEFT ON BRANCH: cập nhật node trên nhánh
         * Left = left + selectionRight + 1(right <= 0)
         * */
        $data = array('left'  =>  DB::raw( "(`left` + " .  ($partnerItem->right + 1) . ")"));
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON BRANCH: cập nhật node trên nhánh
         * + Right = right + selectionRight + totalNode*2 (right <= 0)
         * */
        $data = array('right'  =>  DB::raw( "(`right` + " .  ($partnerItem->right + ($totalDetachNode * 2)) . ")"));
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE PARENT OF NODE MOVE
         * + nodeMove[parent] = selectionParent
         * */
        $data = array( 'parent' => $partnerItem->parent );
        self::parentQuery()->where("$primaryKey", '=', $moveItem->$primaryKey)
            ->update( $data );

        return true;
    }

    /*
     * MOVE NODE BEFORE: di chuyển 1 node hay nhánh làm anh em 1 node. Và nó sẽ ở vị trí bên TRÁI
     * Function chỉ được sử dụng trong moveNode()
     * @param number $paramArr['totalNodeDetach']
     * @param object $paramArr['nodeMoveInfo']
     * @param object $paramArr['nodeSelectionInfo']
     * return boolean
     * */
    private function moveBefore($params = null, $options = null): bool
    {
        $moveItem           = $params['move_item'];
        $partnerItem        = $params['partner_item'];
        $totalDetachNode    = $params['total_detach_node'];
        $primaryKey         = $this->primaryKey;

        /*
         * UPDATE LEFT ON TREE:
         * + Left = Left + totalNode*2 (left >= selectionLeft & right > 0)
         * */
        $data = array( 'left'  =>  DB::raw( "(`left` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('left', '>=', $partnerItem->left)
            ->where('right', '>', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON TREE:
         * + Right = Right + totalNode*2(right > selectionLeft)
         * */
        $data = array( 'right'  =>  DB::raw( "(`right` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('right', '>', $partnerItem->left)
            ->update( $data );


        /*
         * UPDATE LEVEL ON BRANCH: cập nhật node trên nhánh
         * + Level = level – nodeMoveLevel + selectionLevel (right <= 0)
         * */
        $data = array('level'  =>  DB::raw( "(`level` + " .  ($partnerItem->level - $moveItem->level) . ")"));
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE LEFT ON BRANCH: cập nhật node trên nhánh
         * Left = left + selectionLeft(right <= 0)
         * */
        $data = array( 'left'  =>  DB::raw( "(`left` + " .  $partnerItem->left . ")") );
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON BRANCH: cập nhật node trên nhánh
         * + Right = right + selectionLeft + totalNode*2 - 1 (right <= 0)
         * */
        $data = array( 'right'  =>  DB::raw( "(`right` + " .  ($partnerItem->left + ($totalDetachNode * 2) - 1) . ")") );
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE PARENT OF NODE MOVE
         * + nodeMove[parent] = selectionParent
         * */
        $data = array( 'parent' => $partnerItem->parent );
        self::parentQuery()->where("$primaryKey", '=', $moveItem->$primaryKey)
            ->update( $data );

        return true;
    }

    /*
     * MOVE NODE RIGHT: di chuyển 1 node hay nhánh làm con 1 node. Và nó sẽ ở vị trí bên PHẢI
     * Function chỉ được sử dụng trong moveNode()
     * @param number $paramArr['totalNodeDetach']
     * @param object $paramArr['nodeMoveInfo']
     * @param object $paramArr['nodeSelectionInfo']
     * return boolean
     * */
    private function moveRight($params = null, $options = null): bool
    {
        $moveItem           = $params['move_item'];
        $partnerItem        = $params['partner_item'];
        $totalDetachNode    = $params['total_detach_node'];
        $primaryKey         = $this->primaryKey;


        /*
         * UPDATE LEFT ON TREE:
         * + Left = Left + totalNode*2 (left > ParentRight & right > 0)
         * */
        $data = array( 'left'  =>  DB::raw( "(`left` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('left', '>', $partnerItem->right)
            ->where('right', '>', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON TREE: Right = Right + totalNode*2 (right >= ParentRight)
         * */
        $data = array( 'right'  =>  DB::raw( "(`right` + ".($totalDetachNode * 2).")" ) );
        self::parentQuery()->where('right', '>=', $partnerItem->right)
            ->update( $data );


        /*
         * UPDATE LEVEL ON BRANCH: cập nhật node trên nhánh
         * + Level = level – nodeMoveLevel + ParentLevel +1(right <= 0)
         * */
        $data = array('level'  =>  DB::raw( "(`level` + " .  ($partnerItem->level - $moveItem->level + 1) . ")"));
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE LEFT ON BRANCH: cập nhật node trên nhánh
         * Left = left + ParentRight(right <= 0)
         * */
        $data = array( 'left'  =>  DB::raw( "(`left` + ".($partnerItem->right).")" ) );
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE RIGHT ON BRANCH: cập nhật node trên nhánh
         * Right = right + ParentRight +totalNode*2 - 1(right <= 0)
         * */
        $data = array( 'right'  =>  DB::raw( "(`right` + ".($partnerItem->right + ($totalDetachNode * 2) - 1).")" ) );
        self::parentQuery()->where('right', '<=', 0)
            ->update( $data );


        /*
         * UPDATE PARENT OF NODE MOVE
         * + nodeMove[parent] = ParentID
         * */
        $data = array( 'parent' => $partnerItem->$primaryKey );
        self::parentQuery()->where("$primaryKey", '=', $moveItem->$primaryKey)
            ->update( $data );

        return true;
    }

    /*
     * TÁCH NHÁNH hoặc XÓA NHÁNH ( function này chỉ được sử dụng trong moveNode(), removeNode() )
     * 1. TÁCH NHÁNH: Tách 1 nhánh node ra khỏi node cha. Khi $option == null
     * 2. XÓA NHÁNH:  Xóa 1 nhánh. Khi $option['task'] = 'remove-node'
     *
     * @param object paramArr['nodeDetachInfo'] (thông tin của node )
     * return number
     * */
    private function detachBranch($params = null, $options = null){
        $task               = @$options['task'];
        $tasksAllowed       = array('remove-node');
        $isTaskAllowed      = ( $options == null ) ? true : ( in_array( $options['task'], $tasksAllowed ) ? true : false );
        $detachItem         = $params['detach_item'];
        $detachItem_Left    = $detachItem->left;
        $detachItem_Right   = $detachItem->right;
        $primaryKey         = $this->primaryKey;
        /*
         * KHÔNG THỂ TÁCH NODE(NHÁNH): khi node(nhánh) đã tách mà chưa thêm vào nhánh cây mới
         * */
        if ($detachItem->$primaryKey < 1 || $detachItem_Right < 1)
            throw new \Exception('Nhánh(node) đã được tách trước đó');

        if ($isTaskAllowed === false)
            throw new \Exception('Task không được phép');

        /*
         * Tìm tổng số node trên 1 nhánh:
         * TotalNode= (right – left + 1)/2
         * */
        $totalNode = ($detachItem_Right - $detachItem_Left + 1)/2;


        // ====================================== node on branch ======================================
        /*
         * UPDATE: left và right của node con trên một nhánh
         * left = left – nodeMove[left]
         * right = right – nodeMove[right]
         * WHERE:
         * + nodeMove[left] <= left <= nodeMove[right]
         * */
        if (empty($task) || $task == 'default'){
            $dataBranch   = array(
                'left'  =>  DB::raw( "(`left` - $detachItem_Left)" ),
                'right' =>  DB::raw( "(`right` - $detachItem_Right)" )
            );
            self::parentQuery()->whereBetween('left', [$detachItem_Left, $detachItem_Right])->update( $dataBranch );
        }


        // Xóa node
        if ($task == 'remove-node')
            self::parentQuery()->whereBetween('left', [$detachItem_Left, $detachItem_Right])->delete();



        // ====================================== node on TREE(left) ======================================
        /*
         * UPDATE: Với những node có left > nodeMoveInfo.right
         * Node on tree:
         * + Left = left – totalNode*2
         * WHERE:
         * + left > nodeMove[right]
         * */
        $dataTreeLeft   = array( 'left'  =>  DB::raw( "(`left` - " . ($totalNode * 2) .")" ), );
        self::parentQuery()->where('left', '>' , $detachItem_Right)->update( $dataTreeLeft );


        // ====================================== node on TREE(right) ======================================
        /*
         * UPDATE: right của node Với những node có right > nodeMoveInfo.right
         * Node on tree:
         * + Right = right – totalNode*2
         * Where:
         * + right > nodeMove[right]
         * */
        $dataTreeRight   = array( 'right'  =>  DB::raw( "(`right` - " . ($totalNode * 2) .")" ), );
        self::parentQuery()->where('right', '>' , $detachItem_Right)->update( $dataTreeRight );

        return $totalNode;
    }


    /*
     * DELETE NODE OR BRANCH
     * @param number $paramArr['primaryKey']
     * @param type $options['type'] (xóa 1 node hay xóa nhánh)
     * */
    public function removeNode($params, $options = null): bool
    {
        $type       = $options['type'];
        $primaryKey = $this->primaryKey;
        $nodeID     = $params["$primaryKey"];
        $removeItem = $this->getItemNode(["$primaryKey" => $nodeID], ['task' => 'get-item']);
        /*
         * KHÔNG THỂ XÓA NODE(NHÁNH): Khi node ko tồn tại
         * */
        if (@$removeItem->$primaryKey <= 1 ){
            throw new \Exception('Không thể xóa node không tồn tại');
        }

        switch ($type) {
            case 'only': // Xóa 1 node duy nhất
                $this->removeNodeOnly(array('remove_item' => $removeItem));
                break;
            case 'branch': // Xóa 1 nhánh
            default:
                $this->detachBranch(array('detach_item' => $removeItem), array('task' => 'remove-node'));
                break;
        }

        return true;
    }

    /*
     * Xóa 1 node (không xóa node con). Được sử dụng trong removeNode
     * @param object $paramArr['nodeRemoveInfo']
     * */
    private function removeNodeOnly($params, $options = null): bool
    {
        $removeItem = $params['remove_item'];
        $primaryKey = $this->primaryKey;

        $childNodes = $this->getItemsNode(["$primaryKey" => $removeItem->$primaryKey], ['task' => 'list-childs']);

        // Move child node
        if (!empty($childNodes)):
            foreach ($childNodes as $node){
                $item = $this->getItemNode( ["$primaryKey" => $node->$primaryKey], ['task' => 'get-item']);
                $this->moveNode(['move_item' => $item, 'partner_id' => $this->nodePartnerId], ['position' => 'right']);
            }
        endif;

        /*
         * REMOVE NODE
         * */
        // Lấy lại thông tin node cần xóa
        $removeItem = $this->getItemNode( ["$primaryKey" => $removeItem->$primaryKey], ['task' => 'get-item']);
        $this->detachBranch( ['detach_item' => $removeItem], ['task' => 'remove-node']);
        return true;
    }


    public function getItemsNode($params = null, $options = null){
        $task       = $options['task'];
        $results    = null;
        $primaryKey = $this->primaryKey;

        if ($task == 'list-childs'){
            $item = $this->getItemNode($params, ['task' => 'get-item']);
            $results = self::parentQuery()->select('*')
                ->where('parent', '=', $item->$primaryKey)
                ->orderBy('left', 'ASC')->get();
            /*return $results = $this->tableGateway->select(function (Select $select) use ($nodeInfo){
                $select->columns(array('*'))
                    ->order('left ASC')
                    ->where->equalTo('parent', $nodeInfo->$primaryKey);
            })->buffer();*/
        }

        return $results;
    }

    /*
     * GET: lấy thông tin của một node hoặc anh em của một node
     * */
    public function getItemNode($params = null, $options = null){
        $task       = $options['task'];
        $results    = null;
        $primaryKey = $this->primaryKey;

        if ($task == 'get-item'){
            $results = self::parentQuery()->select('*')
                ->where("$primaryKey", $params["$primaryKey"])->first();
        }

        /*
         * GET: lấy 1 node anh em liền kể phía trước 1 node
         * @param object $paramArr['nodeMoveInfo'] (thông tin đầy đủ của node move)
         * @param string $options['task']
         * return object
         * */
        if ($task == 'move-up'){
            $moveItem = $params['move_item'];
            $query = self::parentQuery()->select('*')
                ->limit(1)
                ->orderBy('left', 'desc')
                ->where('parent', '=',  $moveItem->parent)
                ->where("$primaryKey", '!=',     $moveItem->$primaryKey)
                ->where('right', '<',   $moveItem->left)
                ->first()
            ;
            $results = $query;
        }


        return $results;
    }


    /*
     * REMOVE ELEMENT FROM ARRAY: Xóa những phần tử không được phép ra khỏi mảng
     * @param array $dataArr // Mảng dữ liệu đầu vào
     * @param array $tableFieldsNeededRemove // Cần xóa những dữ liệu với key này ra khỏi mảng
     * */
    public function removeElementFromArray($dataArr, $tableFieldsNotUpdateOrInsert){
        if (!is_array($dataArr) && !is_array($tableFieldsNotUpdateOrInsert))
            throw new \Exception('Dữ liệu phải là array');
        return array_diff_key( $dataArr, $tableFieldsNotUpdateOrInsert );
    }



    /*
     * GET: tất cả các fields trong 'nested'
     * */
    public function getTableFields(){
        $fields = DB::select('DESCRIBE ' . $this->table);
        foreach ($fields as  $field)
            $this->tableFields[$field->Field] = null;
        return $this->tableFields;
    }

    /*
     * Tìm giao điểm của 2 mảng. Một mảng là dữ liệu truyền vào, mảng mặc định là table fileds trong db
     * */
    public function arrayIntersectKey($data): array
    {
        $tableFields = $this->getTableFields();
        if (count($tableFields) < 1)
            throw new \Exception('Bảng ' . $this->table . ' chưa có columns.');
        return array_intersect_key($data, $tableFields);
    }
}
